<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\JournalEntry;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')->orderBy('date', 'desc')->get();
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.index', compact('sales', 'products'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'discount' => 'nullable|numeric|min:0',
            'paid' => 'nullable|numeric|min:0',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return back()->withErrors(['quantity' => 'Not enough stock. Available: ' . $product->stock])->withInput();
        }

        // calculate sale amounts
        $saleAmount = $request->quantity * $product->sell_price;
        $discount = $request->discount ?? 0;
        $afterDiscount = $saleAmount - $discount;
        $vat = round($afterDiscount * 0.05, 2); // 5% VAT
        $total = round($afterDiscount + $vat, 2);
        $paid = $request->paid ?? 0;
        $due = round($total - $paid, 2);

        $sale = Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'discount' => $discount,
            'vat' => $vat,
            'total' => $total,
            'paid' => $paid,
            'due' => $due,
            'date' => $request->date,
        ]);

        // reduce stock
        $product->decrement('stock', $request->quantity);

        $cogs = $request->quantity * $product->purchase_price;

        // journal entries for the sale
        if ($paid > 0) {
            JournalEntry::create([
                'account' => 'Cash A/C',
                'debit' => $paid,
                'credit' => 0,
                'date' => $request->date,
                'description' => "Cash received - {$product->name}",
            ]);
        }

        if ($due > 0) {
            JournalEntry::create([
                'account' => 'Accounts Receivable A/C',
                'debit' => $due,
                'credit' => 0,
                'date' => $request->date,
                'description' => "Due from sale - {$product->name}",
            ]);
        }

        JournalEntry::create([
            'account' => 'Sales A/C',
            'debit' => 0,
            'credit' => $afterDiscount,
            'date' => $request->date,
            'description' => "Sold {$request->quantity} x {$product->name}",
        ]);

        JournalEntry::create([
            'account' => 'VAT Payable A/C',
            'debit' => 0,
            'credit' => $vat,
            'date' => $request->date,
            'description' => "VAT on sale - {$product->name}",
        ]);

        // COGS entries
        JournalEntry::create([
            'account' => 'COGS A/C',
            'debit' => $cogs,
            'credit' => 0,
            'date' => $request->date,
            'description' => "Cost of {$request->quantity} x {$product->name}",
        ]);

        JournalEntry::create([
            'account' => 'Inventory A/C',
            'debit' => 0,
            'credit' => $cogs,
            'date' => $request->date,
            'description' => "Stock out - {$product->name}",
        ]);

        return redirect()->route('sales.index')->with('success', "Sale recorded. Total: {$total} TK, Paid: {$paid} TK, Due: {$due} TK");
    }
}

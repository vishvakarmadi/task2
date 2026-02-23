<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\JournalEntry;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('product')->orderBy('date', 'desc')->get();
        $products = Product::all();
        return view('purchases.index', compact('purchases', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        $total = $request->quantity * $product->purchase_price;

        // Create purchase
        Purchase::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total' => $total,
            'date' => $request->date,
        ]);

        // Update stock
        $product->increment('stock', $request->quantity);

        // Journal Entry: Purchase
        JournalEntry::create([
            'account' => 'Inventory A/C',
            'debit' => $total,
            'credit' => 0,
            'date' => $request->date,
            'description' => "Purchased {$request->quantity} units of {$product->name}",
        ]);

        JournalEntry::create([
            'account' => 'Cash A/C',
            'debit' => 0,
            'credit' => $total,
            'date' => $request->date,
            'description' => "Cash paid for purchase of {$product->name}",
        ]);

        return redirect()->route('purchases.index')->with('success', "Purchase recorded! Total: {$total} TK");
    }
}

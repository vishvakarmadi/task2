<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\JournalEntry;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create($request->only('name', 'purchase_price', 'sell_price', 'stock'));

        // opening stock journal entry
        $value = $product->purchase_price * $product->stock;
        if ($value > 0) {
            JournalEntry::create([
                'account' => 'Inventory A/C',
                'debit' => $value,
                'credit' => 0,
                'date' => now()->toDateString(),
                'description' => "Opening stock - {$product->name} ({$product->stock} units)",
            ]);
            JournalEntry::create([
                'account' => 'Cash A/C',
                'debit' => 0,
                'credit' => $value,
                'date' => now()->toDateString(),
                'description' => "Paid for opening stock - {$product->name}",
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product added.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->only('name', 'purchase_price', 'sell_price', 'stock'));
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}

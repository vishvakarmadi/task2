<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\JournalEntry;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalSales = Sale::sum('total');
        $totalPurchases = Purchase::sum('total');
        $totalDue = Sale::sum('due');
        $profit = $totalSales - $totalPurchases;
        $recentSales = Sale::with('product')->orderBy('date', 'desc')->limit(5)->get();
        $recentJournals = JournalEntry::orderBy('date', 'desc')->orderBy('id', 'desc')->limit(5)->get();

        return view('dashboard', compact(
            'totalProducts', 'totalStock', 'totalSales',
            'totalPurchases', 'totalDue', 'profit',
            'recentSales', 'recentJournals'
        ));
    }
}

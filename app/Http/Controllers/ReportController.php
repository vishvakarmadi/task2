<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\JournalEntry;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $salesQuery = Sale::query();
        $purchasesQuery = Purchase::query();
        $journalQuery = JournalEntry::query();

        if ($fromDate && $toDate) {
            $salesQuery->whereBetween('date', [$fromDate, $toDate]);
            $purchasesQuery->whereBetween('date', [$fromDate, $toDate]);
            $journalQuery->whereBetween('date', [$fromDate, $toDate]);
        }

        $totalSell = $salesQuery->sum('total');
        $totalExpense = $purchasesQuery->sum('total');
        $profit = $totalSell - $totalExpense;

        $sales = $salesQuery->with('product')->orderBy('date', 'desc')->get();
        $journalEntries = $journalQuery->orderBy('date', 'desc')->orderBy('id', 'desc')->get();

        return view('reports.index', compact(
            'totalSell', 'totalExpense', 'profit',
            'sales', 'journalEntries',
            'fromDate', 'toDate'
        ));
    }
}

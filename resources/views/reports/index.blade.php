@extends('layouts.app')
@section('title', 'Financial Report - Inventory System')
@section('content')
<div class="d-flex align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-chart-bar me-2" style="color:var(--primary)"></i>Date-wise Financial Report</h4>
        <p class="text-muted mb-0">Filter and analyze your business financials</p>
    </div>
</div>

<!-- Date Filter -->
<div class="card p-3 mb-4">
    <form method="GET" action="{{ route('reports.index') }}" class="row align-items-end g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold">From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ $fromDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ $toDate }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100" style="padding:10px;">
                <i class="fas fa-filter me-1"></i>Filter Report
            </button>
        </div>
    </form>
</div>

<!-- Summary Cards -->
<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card stat-card p-4 text-center" style="border-left-color: var(--success);">
            <div class="text-muted small mb-1 fw-semibold">Total Sales</div>
            <div class="fw-bold fs-3 text-success">{{ number_format($totalSell, 2) }} TK</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-4 text-center" style="border-left-color: var(--danger);">
            <div class="text-muted small mb-1 fw-semibold">Total Expense (Purchases)</div>
            <div class="fw-bold fs-3 text-danger">{{ number_format($totalExpense, 2) }} TK</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card p-4 text-center" style="border-left-color: {{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }};">
            <div class="text-muted small mb-1 fw-semibold">Profit / Loss</div>
            <div class="fw-bold fs-3" style="color: {{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                {{ number_format($profit, 2) }} TK
            </div>
        </div>
    </div>
</div>

@if($fromDate && $toDate)
<div class="alert alert-info">
    <i class="fas fa-calendar me-2"></i>
    Showing results from <strong>{{ \Carbon\Carbon::parse($fromDate)->format('d/m/Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($toDate)->format('d/m/Y') }}</strong>
</div>
@endif

<!-- Sales Table -->
<div class="card p-3 mb-4">
    <h6 class="fw-bold mb-3"><i class="fas fa-cash-register me-2" style="color:var(--primary)"></i>Sales Summary</h6>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Product</th><th>Qty</th><th>Discount</th><th>VAT</th><th>Total</th><th>Paid</th><th>Due</th><th>Date</th></tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="fw-semibold">{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->discount, 2) }}</td>
                    <td>{{ number_format($sale->vat, 2) }}</td>
                    <td class="fw-bold">{{ number_format($sale->total, 2) }}</td>
                    <td class="text-success">{{ number_format($sale->paid, 2) }}</td>
                    <td class="text-danger">{{ number_format($sale->due, 2) }}</td>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No sales in this period</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Journal Entries -->
<div class="card p-3">
    <h6 class="fw-bold mb-3"><i class="fas fa-book me-2" style="color:var(--primary)"></i>Journal Entries</h6>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Date</th><th>Account</th><th>Description</th><th>Debit (TK)</th><th>Credit (TK)</th></tr>
            </thead>
            <tbody>
                @forelse($journalEntries as $entry)
                <tr>
                    <td>{{ $entry->date->format('d/m/Y') }}</td>
                    <td class="fw-semibold">{{ $entry->account }}</td>
                    <td class="text-muted">{{ $entry->description }}</td>
                    <td class="text-success">{{ $entry->debit > 0 ? number_format($entry->debit, 2) : '-' }}</td>
                    <td class="text-danger">{{ $entry->credit > 0 ? number_format($entry->credit, 2) : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No entries in this period</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

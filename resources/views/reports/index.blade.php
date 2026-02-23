@extends('layouts.app')
@section('title', 'Reports')
@section('content')
<h4 class="mb-3">Financial Report</h4>

{{-- date filter --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">From Date</label>
                <input type="date" name="from_date" class="form-control" value="{{ $fromDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">To Date</label>
                <input type="date" name="to_date" class="form-control" value="{{ $toDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- summary --}}
<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card p-3 border-start border-4 border-success">
            <small class="text-muted">Total Sales</small>
            <h4 class="mb-0 text-success">{{ number_format($totalSell, 2) }} TK</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 border-start border-4 border-danger">
            <small class="text-muted">Total Expenses (Purchases)</small>
            <h4 class="mb-0 text-danger">{{ number_format($totalExpense, 2) }} TK</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 border-start border-4 {{ $profit >= 0 ? 'border-success' : 'border-danger' }}">
            <small class="text-muted">{{ $profit >= 0 ? 'Profit' : 'Loss' }}</small>
            <h4 class="mb-0 {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format(abs($profit), 2) }} TK</h4>
        </div>
    </div>
</div>

{{-- sales table --}}
<div class="card mb-4">
    <div class="card-header"><strong>Sales Details</strong></div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead><tr><th>Date</th><th>Product</th><th>Qty</th><th>Total</th><th>Paid</th><th>Due</th></tr></thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->total, 2) }}</td>
                    <td class="text-success">{{ number_format($sale->paid, 2) }}</td>
                    <td class="text-danger">{{ number_format($sale->due, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-3">No sales in this period</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- journal table --}}
<div class="card">
    <div class="card-header"><strong>Journal Entries</strong></div>
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead><tr><th>Date</th><th>Account</th><th>Description</th><th>Debit</th><th>Credit</th></tr></thead>
            <tbody>
                @forelse($journalEntries as $entry)
                <tr>
                    <td>{{ $entry->date->format('d/m/Y') }}</td>
                    <td><strong>{{ $entry->account }}</strong></td>
                    <td class="text-muted">{{ $entry->description }}</td>
                    <td class="text-success">{{ $entry->debit > 0 ? number_format($entry->debit, 2) : '' }}</td>
                    <td class="text-danger">{{ $entry->credit > 0 ? number_format($entry->credit, 2) : '' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">No entries in this period</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

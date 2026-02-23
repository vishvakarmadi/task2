@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h4 class="mb-4">Dashboard</h4>

{{-- summary cards --}}
<div class="row mb-4 g-3">
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: #0d6efd;">
            <small class="text-muted">Products</small>
            <h5 class="mb-0">{{ $totalProducts }}</h5>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: #198754;">
            <small class="text-muted">Total Stock</small>
            <h5 class="mb-0">{{ $totalStock }}</h5>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: #198754;">
            <small class="text-muted">Sales</small>
            <h5 class="mb-0">{{ number_format($totalSales, 2) }} TK</h5>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: #dc3545;">
            <small class="text-muted">Purchases</small>
            <h5 class="mb-0">{{ number_format($totalPurchases, 2) }} TK</h5>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: #ffc107;">
            <small class="text-muted">Due</small>
            <h5 class="mb-0">{{ number_format($totalDue, 2) }} TK</h5>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: {{ $profit >= 0 ? '#198754' : '#dc3545' }};">
            <small class="text-muted">Profit</small>
            <h5 class="mb-0 {{ $profit >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($profit, 2) }} TK</h5>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- recent sales --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header"><strong>Recent Sales</strong></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Product</th><th>Qty</th><th>Total</th><th>Paid</th><th>Due</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->product->name }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ number_format($sale->total, 2) }}</td>
                            <td class="text-success">{{ number_format($sale->paid, 2) }}</td>
                            <td class="text-danger">{{ number_format($sale->due, 2) }}</td>
                            <td>{{ $sale->date->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No sales yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- recent journals --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><strong>Recent Journal Entries</strong></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Account</th><th>Debit</th><th>Credit</th></tr></thead>
                    <tbody>
                        @forelse($recentJournals as $entry)
                        <tr>
                            <td>{{ $entry->account }}</td>
                            <td class="text-success">{{ $entry->debit > 0 ? number_format($entry->debit, 2) : '-' }}</td>
                            <td class="text-danger">{{ $entry->credit > 0 ? number_format($entry->credit, 2) : '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">No entries yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

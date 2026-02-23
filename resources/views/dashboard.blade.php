@extends('layouts.app')
@section('title', 'Dashboard - Inventory System')
@section('content')
<div class="d-flex align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-tachometer-alt me-2" style="color:var(--primary)"></i>Dashboard</h4>
        <p class="text-muted mb-0">Overview of your inventory and financials</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4 g-3">
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: var(--primary);">
            <div class="text-muted small fw-semibold">Products</div>
            <div class="fw-bold fs-4">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: var(--info);">
            <div class="text-muted small fw-semibold">Total Stock</div>
            <div class="fw-bold fs-4">{{ $totalStock }}</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: var(--success);">
            <div class="text-muted small fw-semibold">Total Sales</div>
            <div class="fw-bold fs-4">{{ number_format($totalSales, 2) }} TK</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: var(--danger);">
            <div class="text-muted small fw-semibold">Total Purchases</div>
            <div class="fw-bold fs-4">{{ number_format($totalPurchases, 2) }} TK</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: var(--warning);">
            <div class="text-muted small fw-semibold">Total Due</div>
            <div class="fw-bold fs-4">{{ number_format($totalDue, 2) }} TK</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card p-3" style="border-left-color: {{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }};">
            <div class="text-muted small fw-semibold">Profit</div>
            <div class="fw-bold fs-4" style="color: {{ $profit >= 0 ? 'var(--success)' : 'var(--danger)' }}">{{ number_format($profit, 2) }} TK</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent Sales -->
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="fas fa-cash-register me-2" style="color:var(--primary)"></i>Recent Sales</h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Product</th><th>Qty</th><th>Total</th><th>Paid</th><th>Due</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td class="fw-semibold">{{ $sale->product->name }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ number_format($sale->total, 2) }}</td>
                            <td class="text-success fw-semibold">{{ number_format($sale->paid, 2) }}</td>
                            <td class="text-danger fw-semibold">{{ number_format($sale->due, 2) }}</td>
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

    <!-- Recent Journal Entries -->
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="fas fa-book me-2" style="color:var(--primary)"></i>Recent Journal Entries</h6>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead><tr><th>Account</th><th>Debit</th><th>Credit</th></tr></thead>
                    <tbody>
                        @forelse($recentJournals as $entry)
                        <tr>
                            <td class="fw-semibold">{{ $entry->account }}</td>
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

@extends('layouts.app')
@section('title', 'Sales - Inventory System')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-cash-register me-2" style="color:var(--primary)"></i>Sales</h4>
        <p class="text-muted mb-0">View all recorded sales</p>
    </div>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>New Sale
    </a>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Discount (TK)</th>
                    <th>VAT (TK)</th>
                    <th>Total (TK)</th>
                    <th>Paid (TK)</th>
                    <th>Due (TK)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td class="fw-semibold">{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->discount, 2) }}</td>
                    <td>{{ number_format($sale->vat, 2) }}</td>
                    <td class="fw-bold">{{ number_format($sale->total, 2) }}</td>
                    <td class="text-success fw-semibold">{{ number_format($sale->paid, 2) }}</td>
                    <td class="text-danger fw-semibold">{{ number_format($sale->due, 2) }}</td>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No sales recorded yet</td></tr>
                @endforelse
            </tbody>
            @if($sales->count() > 0)
            <tfoot class="table-light">
                <tr class="fw-bold">
                    <td colspan="4"></td>
                    <td>{{ number_format($sales->sum('vat'), 2) }}</td>
                    <td>{{ number_format($sales->sum('total'), 2) }}</td>
                    <td class="text-success">{{ number_format($sales->sum('paid'), 2) }}</td>
                    <td class="text-danger">{{ number_format($sales->sum('due'), 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection

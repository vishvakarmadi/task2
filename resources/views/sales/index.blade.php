@extends('layouts.app')
@section('title', 'Sales')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Sales</h4>
    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i>New Sale
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Discount</th>
                    <th>VAT</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->date->format('d/m/Y') }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->discount, 2) }}</td>
                    <td>{{ number_format($sale->vat, 2) }}</td>
                    <td><strong>{{ number_format($sale->total, 2) }}</strong></td>
                    <td class="text-success">{{ number_format($sale->paid, 2) }}</td>
                    <td class="text-danger">{{ number_format($sale->due, 2) }}</td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-3">No sales recorded yet</td></tr>
                @endforelse
            </tbody>
            @if($sales->count())
            <tfoot class="table-light">
                <tr>
                    <td colspan="5" class="text-end"><strong>Totals:</strong></td>
                    <td><strong>{{ number_format($sales->sum('total'), 2) }}</strong></td>
                    <td class="text-success"><strong>{{ number_format($sales->sum('paid'), 2) }}</strong></td>
                    <td class="text-danger"><strong>{{ number_format($sales->sum('due'), 2) }}</strong></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection

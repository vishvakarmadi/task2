@extends('layouts.app')
@section('title', 'Purchases - Inventory System')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-truck me-2" style="color:var(--primary)"></i>Purchases</h4>
        <p class="text-muted mb-0">Record and track stock purchases</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPurchaseModal">
        <i class="fas fa-plus me-1"></i>New Purchase
    </button>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total (TK)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td class="fw-semibold">{{ $purchase->product->name }}</td>
                    <td>{{ $purchase->quantity }}</td>
                    <td class="fw-bold">{{ number_format($purchase->total, 2) }}</td>
                    <td>{{ $purchase->date->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No purchases recorded yet</td></tr>
                @endforelse
            </tbody>
            @if($purchases->count() > 0)
            <tfoot class="table-light">
                <tr class="fw-bold">
                    <td colspan="3">Total</td>
                    <td>{{ number_format($purchases->sum('total'), 2) }} TK</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

<!-- Add Purchase Modal -->
<div class="modal fade" id="addPurchaseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('purchases.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-truck me-2"></i>New Purchase</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->purchase_price }} TK/unit)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Record Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'New Sale - Inventory System')
@section('content')
<h4 class="fw-bold mb-4"><i class="fas fa-cash-register me-2" style="color:var(--primary)"></i>Create New Sale</h4>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card p-4">
            <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                data-sell-price="{{ $product->sell_price }}" 
                                data-purchase-price="{{ $product->purchase_price }}"
                                data-stock="{{ $product->stock }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (Stock: {{ $product->stock }}, Sell: {{ $product->sell_price }} TK)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', 1) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Discount (TK)</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="{{ old('discount', 0) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Customer Paid (TK)</label>
                        <input type="number" step="0.01" name="paid" id="paid" class="form-control" value="{{ old('paid', 0) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2" style="padding:12px;">
                    <i class="fas fa-check me-2"></i>Record Sale
                </button>
            </form>
        </div>
    </div>

    <!-- Live Calculation Preview -->
    <div class="col-md-5">
        <div class="card p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-calculator me-2" style="color:var(--primary)"></i>Invoice Preview</h6>
            <table class="table table-sm">
                <tr><td>Sale Amount</td><td class="text-end fw-bold" id="saleAmount">0.00 TK</td></tr>
                <tr><td>Discount</td><td class="text-end text-danger" id="discountDisplay">- 0.00 TK</td></tr>
                <tr><td>After Discount</td><td class="text-end" id="afterDiscount">0.00 TK</td></tr>
                <tr><td>VAT (5%)</td><td class="text-end" id="vatDisplay">0.00 TK</td></tr>
                <tr style="background:#eef2ff;"><td class="fw-bold">Total Invoice</td><td class="text-end fw-bold fs-5" id="totalInvoice" style="color:var(--primary)">0.00 TK</td></tr>
                <tr><td>Customer Paid</td><td class="text-end text-success fw-bold" id="paidDisplay">0.00 TK</td></tr>
                <tr style="background:#fef2f2;"><td class="fw-bold">Due</td><td class="text-end fw-bold text-danger" id="dueDisplay">0.00 TK</td></tr>
            </table>
            <hr>
            <h6 class="fw-bold mb-2"><i class="fas fa-book me-2" style="color:var(--info)"></i>COGS</h6>
            <p class="mb-0 text-muted" id="cogsDisplay">Cost of Goods Sold: 0.00 TK</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function calculate() {
    const select = document.getElementById('product_id');
    const option = select.options[select.selectedIndex];
    const sellPrice = parseFloat(option?.dataset?.sellPrice || 0);
    const purchasePrice = parseFloat(option?.dataset?.purchasePrice || 0);
    const qty = parseInt(document.getElementById('quantity').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const paid = parseFloat(document.getElementById('paid').value) || 0;

    const saleAmount = qty * sellPrice;
    const afterDiscount = saleAmount - discount;
    const vat = afterDiscount * 0.05;
    const total = afterDiscount + vat;
    const due = total - paid;
    const cogs = qty * purchasePrice;

    document.getElementById('saleAmount').textContent = saleAmount.toFixed(2) + ' TK';
    document.getElementById('discountDisplay').textContent = '- ' + discount.toFixed(2) + ' TK';
    document.getElementById('afterDiscount').textContent = afterDiscount.toFixed(2) + ' TK';
    document.getElementById('vatDisplay').textContent = vat.toFixed(2) + ' TK';
    document.getElementById('totalInvoice').textContent = total.toFixed(2) + ' TK';
    document.getElementById('paidDisplay').textContent = paid.toFixed(2) + ' TK';
    document.getElementById('dueDisplay').textContent = due.toFixed(2) + ' TK';
    document.getElementById('cogsDisplay').textContent = 'Cost of Goods Sold: ' + cogs.toFixed(2) + ' TK';
}

document.getElementById('product_id').addEventListener('change', calculate);
document.getElementById('quantity').addEventListener('input', calculate);
document.getElementById('discount').addEventListener('input', calculate);
document.getElementById('paid').addEventListener('input', calculate);
calculate();
</script>
@endsection

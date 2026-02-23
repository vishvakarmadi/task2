@extends('layouts.app')
@section('title', 'New Sale')
@section('content')
<h4 class="mb-4">Create New Sale</h4>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Product</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    data-sell-price="{{ $product->sell_price }}"
                                    data-purchase-price="{{ $product->purchase_price }}"
                                    data-stock="{{ $product->stock }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stock: {{ $product->stock }}, Price: {{ $product->sell_price }} TK)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{ old('quantity', 1) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount (TK)</label>
                            <input type="number" step="0.01" name="discount" id="discount" class="form-control" value="{{ old('discount', 0) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Amount Paid (TK)</label>
                            <input type="number" step="0.01" name="paid" id="paid" class="form-control" value="{{ old('paid', 0) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Record Sale</button>
                </form>
            </div>
        </div>
    </div>

    {{-- live invoice preview --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><strong>Invoice Preview</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><td>Sale Amount</td><td class="text-end" id="saleAmount">0.00 TK</td></tr>
                    <tr><td>Discount</td><td class="text-end text-danger" id="discountDisplay">- 0.00 TK</td></tr>
                    <tr><td>After Discount</td><td class="text-end" id="afterDiscount">0.00 TK</td></tr>
                    <tr><td>VAT (5%)</td><td class="text-end" id="vatDisplay">0.00 TK</td></tr>
                    <tr class="table-primary"><td><strong>Total</strong></td><td class="text-end fw-bold" id="totalInvoice">0.00 TK</td></tr>
                    <tr><td>Paid</td><td class="text-end text-success" id="paidDisplay">0.00 TK</td></tr>
                    <tr class="table-danger"><td><strong>Due</strong></td><td class="text-end fw-bold" id="dueDisplay">0.00 TK</td></tr>
                </table>
                <hr>
                <small class="text-muted" id="cogsDisplay">COGS: 0.00 TK</small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// live calculator for invoice preview
function calculate() {
    var sel = document.getElementById('product_id');
    var opt = sel.options[sel.selectedIndex];
    var sellPrice = parseFloat(opt?.dataset?.sellPrice || 0);
    var buyPrice = parseFloat(opt?.dataset?.purchasePrice || 0);
    var qty = parseInt(document.getElementById('quantity').value) || 0;
    var disc = parseFloat(document.getElementById('discount').value) || 0;
    var paid = parseFloat(document.getElementById('paid').value) || 0;

    var amount = qty * sellPrice;
    var afterDisc = amount - disc;
    var vat = afterDisc * 0.05;
    var total = afterDisc + vat;
    var due = total - paid;
    var cogs = qty * buyPrice;

    document.getElementById('saleAmount').textContent = amount.toFixed(2) + ' TK';
    document.getElementById('discountDisplay').textContent = '- ' + disc.toFixed(2) + ' TK';
    document.getElementById('afterDiscount').textContent = afterDisc.toFixed(2) + ' TK';
    document.getElementById('vatDisplay').textContent = vat.toFixed(2) + ' TK';
    document.getElementById('totalInvoice').textContent = total.toFixed(2) + ' TK';
    document.getElementById('paidDisplay').textContent = paid.toFixed(2) + ' TK';
    document.getElementById('dueDisplay').textContent = due.toFixed(2) + ' TK';
    document.getElementById('cogsDisplay').textContent = 'COGS: ' + cogs.toFixed(2) + ' TK';
}

document.getElementById('product_id').addEventListener('change', calculate);
document.getElementById('quantity').addEventListener('input', calculate);
document.getElementById('discount').addEventListener('input', calculate);
document.getElementById('paid').addEventListener('input', calculate);
calculate();
</script>
@endsection

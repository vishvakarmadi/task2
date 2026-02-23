@extends('layouts.app')
@section('title', 'Products - Inventory System')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-box me-2" style="color:var(--primary)"></i>Products</h4>
        <p class="text-muted mb-0">Manage your product inventory</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
        <i class="fas fa-plus me-1"></i>Add Product
    </button>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Purchase Price (TK)</th>
                    <th>Sell Price (TK)</th>
                    <th>Stock</th>
                    <th>Inventory Value (TK)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td class="fw-semibold">{{ $product->name }}</td>
                    <td>{{ number_format($product->purchase_price, 2) }}</td>
                    <td>{{ number_format($product->sell_price, 2) }}</td>
                    <td><span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">{{ $product->stock }}</span></td>
                    <td class="fw-semibold">{{ number_format($product->purchase_price * $product->stock, 2) }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProduct{{ $product->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('products.update', $product) }}">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Edit {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Purchase Price (TK)</label>
                                        <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Sell Price (TK)</label>
                                        <input type="number" step="0.01" name="sell_price" class="form-control" value="{{ $product->sell_price }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Stock</label>
                                        <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No products found. Add your first product!</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-plus me-2"></i>Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Widget" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Purchase Price (TK)</label>
                        <input type="number" step="0.01" name="purchase_price" class="form-control" placeholder="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sell Price (TK)</label>
                        <input type="number" step="0.01" name="sell_price" class="form-control" placeholder="200" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Opening Stock</label>
                        <input type="number" name="stock" class="form-control" placeholder="50" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

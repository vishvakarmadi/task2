@extends('layouts.app')
@section('title', 'Products')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Products</h4>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
        <i class="fas fa-plus me-1"></i>Add Product
    </button>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Purchase Price</th>
                    <th>Sell Price</th>
                    <th>Stock</th>
                    <th>Inventory Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->purchase_price, 2) }} TK</td>
                    <td>{{ number_format($product->sell_price, 2) }} TK</td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">0</span>
                        @endif
                    </td>
                    <td>{{ number_format($product->purchase_price * $product->stock, 2) }} TK</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProduct{{ $product->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                {{-- edit modal --}}
                <div class="modal fade" id="editProduct{{ $product->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('products.update', $product) }}">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Purchase Price (TK)</label>
                                        <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sell Price (TK)</label>
                                        <input type="number" step="0.01" name="sell_price" class="form-control" value="{{ $product->sell_price }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Stock</label>
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
                <tr><td colspan="7" class="text-center text-muted py-3">No products yet. Add one above.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- add product modal --}}
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Widget" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Purchase Price (TK)</label>
                        <input type="number" step="0.01" name="purchase_price" class="form-control" placeholder="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sell Price (TK)</label>
                        <input type="number" step="0.01" name="sell_price" class="form-control" placeholder="200" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Opening Stock</label>
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

@extends('layouts.master')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Your Shopping Cart</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (empty($cart))
            <div class="empty-cart text-center py-5">
                <i class="fas fa-shopping-cart fa-4x mb-3 text-muted"></i>
                <h3 class="mb-3">Your cart is empty</h3>
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 40%">Product</th>
                            <th scope="col" class="text-end">Price</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-end">Total</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="img-thumbnail me-3" 
                                         style="width: 80px; height: 80px; object-fit: cover;">
                                    <div>
                                        <h5 class="mb-1">{{ $item['name'] }}</h5>
                                        <small class="text-muted">SKU: {{ $id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">${{ number_format($item['price'], 2) }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex justify-content-center">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group" style="max-width: 120px;">
                                        <input type="number" 
                                               name="quantity" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1" 
                                               class="form-control form-control-sm text-center">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="text-end">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-5 ms-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total:</span>
                                <span>${{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 2) }}</span>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                                Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    .empty-cart {
        background-color: #f8f9fa;
        border-radius: 10px;
    }
    
    .cart-product-image {
        max-width: 80px;
        max-height: 80px;
        object-fit: cover;
    }
    
    .quantity-input {
        width: 60px;
        text-align: center;
    }
    
    .update-btn, .remove-btn {
        transition: all 0.2s;
    }
    
    .update-btn:hover {
        transform: rotate(15deg);
    }
    
    .remove-btn:hover {
        color: #dc3545 !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hiệu ứng khi cập nhật số lượng
    document.querySelectorAll('.update-quantity-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
        });
    });
    
    // Xác nhận trước khi xóa
    document.querySelectorAll('.remove-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to remove this item?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endpush
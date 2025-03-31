@extends('layouts.master')

@section('title', 'Product Details')

@section('content')
    <div class="product-detail-container">
        <!-- Cột bên trái: Thông tin sản phẩm -->
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <p class="product-description">{{ $product->description }}</p>
            <p class="product-price"><strong>Price:</strong> ${{ $product->price }}</p>
            <p class="product-category"><strong>Category:</strong> {{ $product->category->name }}</p>

            <!-- Form thêm sản phẩm vào giỏ hàng -->
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1" class="quantity-input">
                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
            </form>

            <a href="{{ route('products.index') }}" class="back-to-list-btn">Back to Product List</a>
        </div>

        <!-- Cột bên phải: Hình ảnh sản phẩm -->
        <div class="product-image">
            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
        </div>
    </div>
@endsection
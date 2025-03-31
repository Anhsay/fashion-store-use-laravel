@extends('layouts.master')

@section('title', 'Product List')

@section('content')
    <div class="product-list-container">
        <h1>Product List</h1>
        <!-- Form lọc sản phẩm theo danh mục -->
        <form action="{{ route('products.index') }}" method="GET" class="filter-form">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Danh sách sản phẩm -->
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="product-price">${{ $product->price }}</p>
                        <p class="product-category">{{ $product->category->name }}</p>
                        <!-- Nút "View Details" -->
                        <a href="{{ route('products.show', $product->id) }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
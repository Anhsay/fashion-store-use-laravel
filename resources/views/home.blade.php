@extends('layouts.master')

@section('title', 'Trang chủ - Fashion Store')

@section('content')
    <!-- Slider -->
    <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://picsum.photos/1200/400" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="https://via.placeholder.com/1200x400" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="https://picsum.photos/1200/400" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Slider -->
    <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
        <!-- Nội dung slider như trên -->
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row">
        <div class="col-md-12">
            <h2>Sản phẩm mới nhất</h2>
        </div>
    </div>

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                        <a href="{{ route('products.show', $product->id) }}" class="view-details-btn">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection 
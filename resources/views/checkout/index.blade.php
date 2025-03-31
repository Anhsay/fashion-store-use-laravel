@extends('layouts.master')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Checkout</h2>
            
            <!-- Form thông tin thanh toán -->
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ auth()->user() ? auth()->user()->name : old('name') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ auth()->user() ? auth()->user()->email : old('email') }}" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="{{ old('phone') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" 
                                       value="{{ old('address') }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú (tùy chọn)</label>
                            <textarea class="form-control" id="note" name="note" rows="2">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Phương thức thanh toán</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="vnpay" value="vnpay">
                            <label class="form-check-label d-flex align-items-center" for="vnpay">
                                <span>Thanh toán qua</span>
                                <img src="{{ asset('images/vnpay-logo.png') }}" alt="VNPay" 
                                     class="ms-2" style="height: 20px;">
                            </label>
                        </div>
                        
                        <div id="vnpay-description" class="alert alert-info d-none">
                            <small>
                                <i class="fas fa-info-circle me-2"></i>
                                Bạn sẽ được chuyển đến cổng thanh toán VNPay để hoàn tất giao dịch
                            </small>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-shopping-bag me-2"></i> Đặt hàng
                </button>
            </form>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Tóm tắt đơn hàng</h5>
                </div>
                <div class="card-body">
                    @include('partials.order-summary', ['cart' => $cart, 'total' => $total])
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary mt-3">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại giỏ hàng
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>     
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Script đã được tải"); // Thêm dòng này
            document.addEventListener('DOMContentLoaded', function() {
                console.log("DOM đã sẵn sàng"); // Và thêm dòng này
            
            const form = document.getElementById('checkout-form');
            if (!form) {
                console.error('Không tìm thấy form checkout');
                return;
            }

            // Debug sự kiện submit
            form.addEventListener('submit', function(e) {
                console.log('Form submit triggered'); // Xác nhận sự kiện submit
                
                // Kiểm tra các trường bắt buộc
                const requiredFields = ['name', 'email', 'phone', 'address'];
                let isValid = true;
                
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        console.warn(`Trường ${field} chưa được điền`);
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault(); // Ngăn form submit nếu không hợp lệ
                    console.error('Vui lòng điền đầy đủ thông tin');
                    alert('Vui lòng điền đầy đủ các trường bắt buộc');
                    return false;
                }

                console.log('Form validation passed');
                return true;
            });
        });
    </script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="alert alert-success">
        <h4 class="alert-heading">Đặt hàng thành công!</h4>
        <p>Mã đơn hàng: #{{ $order->id }}</p>
        <p>Tổng tiền: {{ number_format($order->total_amount) }} VND</p>
        <p>Phương thức thanh toán: {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'VNPay' }}</p>
    </div>
</div>
@endsection
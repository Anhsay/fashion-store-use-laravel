<div class="order-summary">
    <ul class="list-group list-group-flush mb-3">
        @foreach($cart as $id => $item)
        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/' . $item['image']) }}" 
                     alt="{{ $item['name'] }}" 
                     class="img-thumbnail me-3" 
                     style="width: 60px; height: 60px; object-fit: cover;">
                <div>
                    <h6 class="mb-0">{{ $item['name'] }}</h6>
                    <small class="text-muted">${{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</small>
                </div>
            </div>
            <span class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
        </li>
        @endforeach
    </ul>

    <div class="d-flex justify-content-between mb-2">
        <span>Subtotal:</span>
        <span>${{ number_format($total, 2) }}</span>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
        <span>Shipping:</span>
        <span>Free</span>
    </div>
    
    <hr>
    
    <div class="d-flex justify-content-between fw-bold fs-5">
        <span>Total:</span>
        <span>${{ number_format($total, 2) }}</span>
    </div>
</div>
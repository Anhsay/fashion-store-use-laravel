<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\VNPayService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct(
        private VNPayService $vnpayService
    ) {
        $this->middleware('auth')->except(['vnpayReturn']);
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Giỏ hàng của bạn đang trống');
        }
        
        return view('checkout.index', [
            'cart' => $cart,
            'total' => $this->calculateTotal($cart)
        ]);
    }
    
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        Log::info('Bắt đầu xử lý thanh toán', $request->all());
    
        $cart = session()->get('cart', []);
        Log::debug('Giỏ hàng hiện tại:', $cart);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'payment_method' => 'required|string|in:cod,vnpay'
        ]);
        
        try {
            DB::beginTransaction();
            
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'],
                'customer_address' => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'total_amount' => $this->calculateTotal($cart),
                'status' => 'pending'
            ]);
            
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
                
                // Có thể thêm logic cập nhật số lượng tồn kho ở đây
                // Product::where('id', $id)->decrement('stock', $item['quantity']);
            }
            
            DB::commit();
            
            if ($validated['payment_method'] === 'vnpay') {
                $paymentUrl = $this->vnpayService->createPayment(
                    $order->id,
                    $order->total_amount,
                    'Thanh toán đơn hàng #' . $order->id,
                    $validated['email'],
                    $validated['phone']
                );
                
                session()->forget('cart');
                return redirect()->away($paymentUrl);
            }
            
            session()->forget('cart');
            return redirect()->route('checkout.success', $order->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng');
        }
    }
    
    public function vnpayReturn(Request $request)
    {
        $inputData = $request->all();
        
        if (!$this->vnpayService->validateReturn($inputData)) {
            Log::warning('VNPay invalid response', $inputData);
            return redirect()->route('checkout.index')->with('error', 'Giao dịch không hợp lệ');
        }
        
        try {
            $order = Order::findOrFail($inputData['vnp_TxnRef']);
            
            if ($inputData['vnp_ResponseCode'] === '00') {
                $order->update([
                    'status' => 'paid',
                    'payment_code' => $inputData['vnp_TransactionNo'],
                    'bank_code' => $inputData['vnp_BankCode'] ?? null
                ]);
                
                // Gửi email xác nhận thanh toán
                // dispatch(new SendPaymentConfirmation($order));
                
                return redirect()->route('checkout.success', $order->id);
            }
            
            return redirect()->route('checkout.index')
                ->with('error', 'Thanh toán thất bại: ' . ($inputData['vnp_ResponseMessage'] ?? 'Lỗi không xác định'));
                
        } catch (\Exception $e) {
            Log::error('VNPay return error: ' . $e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'Lỗi xử lý đơn hàng');
        }
    }
    
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('checkout.success', [
            'order' => $order,
            'items' => $order->items()->with('product')->get()
        ]);
    }
    
    protected function calculateTotal(array $cart): float
    {
        return array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }
}
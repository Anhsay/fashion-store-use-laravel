<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng (đã có)
    public function add($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.view')->with('success', 'Product added to cart successfully!');
    }

    // Xem giỏ hàng (đã có)
    public function view()
    {
        $cart = session()->get('cart', []);
        return view('cart.view', compact('cart'));
    }

    // Cập nhật số lượng sản phẩm
    public function update($itemId, Request $request)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$itemId])) {
            $quantity = $request->input('quantity');
            if($quantity > 0) {
                $cart[$itemId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Cập nhật số lượng thành công!');
            }
        }
        
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng');
    }
    
    public function remove($itemId)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$itemId])) {
            unset($cart[$itemId]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }
}
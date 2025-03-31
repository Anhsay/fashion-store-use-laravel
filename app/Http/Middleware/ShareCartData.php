<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShareCartData
{
    public function handle(Request $request, Closure $next)
    {
        $cart = session()->get('cart', []);
        view()->share('cart', $cart);
        
        return $next($request);
    }
}
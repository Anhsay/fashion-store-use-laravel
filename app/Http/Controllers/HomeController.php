<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm mới nhất
        $products = Product::latest()->take(6)->get();
        
        return view('home', compact('products'));
    }
}
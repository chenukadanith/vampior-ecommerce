<?php

namespace App\Http\Controllers;
use App\Models\Product;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Fetch all products, newest first
        $products = Product::latest()->get();
        return view('dashboard', compact('products'));
    }
}

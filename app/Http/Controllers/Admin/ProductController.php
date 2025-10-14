<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        // Admins see all products from all sellers
        $products = Product::with('seller')->latest()->get();
        return view('products.index', compact('products'));
    }
}


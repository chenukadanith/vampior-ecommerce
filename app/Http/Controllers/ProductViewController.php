<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    /**
     * Display the specified product.
     *
     * Laravel automatically finds the Product by its slug from the URL.
     */
    public function show(Product $product)
    {
        return view('product-detail', compact('product'));
    }
}


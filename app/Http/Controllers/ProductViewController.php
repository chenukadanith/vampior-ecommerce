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
        // Get the IDs of products in the user's wishlist
        $wishlistProductIds = auth()->user()->wishlist()->pluck('products.id')->toArray();
        
        // Pass the product and the wishlist IDs to the view
        return view('product-detail', compact('product', 'wishlistProductIds'));
    }
}


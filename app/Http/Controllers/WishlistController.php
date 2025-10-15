<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist.
     */
    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()->latest()->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add a product to the user's wishlist.
     */
    public function add(Product $product)
    {
        // Use syncWithoutDetaching to add the item without creating duplicates
        auth()->user()->wishlist()->syncWithoutDetaching($product->id);
        return redirect()->back()->with('success', 'Product added to your wishlist!');
    }

    /**
     * Remove a product from the user's wishlist.
     */
    public function remove(Product $product)
    {
        // Use detach to remove the item from the pivot table
        auth()->user()->wishlist()->detach($product->id);
        return redirect()->back()->with('success', 'Product removed from your wishlist.');
    }
}


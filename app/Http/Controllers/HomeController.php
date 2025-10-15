<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard with products, with optional filtering and searching.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = Product::query();

        // If a category is selected, filter by it
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // If a search term is entered, filter by it
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        // Execute the query and paginate results
        $products = $query->latest()->paginate(12);

        // Get all categories for the filter dropdown
        $categories = Category::all();

        // NEW: Get an array of product IDs that are in the user's wishlist
        $wishlistProductIds = auth()->user()->wishlist()->pluck('products.id')->toArray();

        // MODIFIED: Pass the new wishlist IDs variable to the view
        return view('dashboard', compact('products', 'categories', 'wishlistProductIds'));
    }
}


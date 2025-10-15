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
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        // MODIFIED: Use paginate instead of get() to enable a "See More" feature
        $products = $query->latest()->paginate(12);

        $categories = Category::all();

        // Pass the paginated products and categories to the view
        return view('dashboard', compact('products', 'categories'));
    }
}


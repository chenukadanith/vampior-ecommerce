<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // <-- Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the seller's products.
     */
    public function index()
    {
        // Fetch only the products belonging to the currently authenticated seller
        $products = auth()->user()->products()->latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // MODIFIED: Fetch categories to pass to the form
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // MODIFIED: Update validation for category_id
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            // Using your quick fix with Laravel's built-in storage
            $path = $image->storeAs('products', $filename, 'public');
        }

        // MODIFIED: Use category_id instead of category
        auth()->user()->products()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'tags' => $request->tags,
            'stock_quantity' => $request->stock_quantity,
            'image' => $path,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Authorize using the ProductPolicy
        $this->authorize('update', $product);
        // MODIFIED: Fetch categories to pass to the form
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Authorize using the ProductPolicy
        $this->authorize('update', $product);

        // MODIFIED: Update validation for category_id
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $product->image;
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // This is still using the old Intervention Image syntax. Let's keep your quick fix for consistency.
            $path = $image->storeAs('products', $filename, 'public');
        }

        // MODIFIED: Use category_id instead of category
        $product->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'tags' => $request->tags,
            'stock_quantity' => $request->stock_quantity,
            'image' => $path,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Authorize using the ProductPolicy
        $this->authorize('delete', $product);

        // Delete the image file
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

   
    public function index()
    {
        // Admins see all products from all sellers
        $products = Product::with('seller', 'category')->latest()->get();
        return view('products.index', compact('products'));
    }

    
    public function create()
    {
        $categories = Category::all();
        // Admins need a list of sellers to assign the product to
        $sellers = User::role('seller')->get();
        return view('admin.products.create', compact('categories', 'sellers'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id', 
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
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/products/' . $filename));
            $path = 'products/' . $filename;
        }

        Product::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'tags' => $request->tags,
            'stock_quantity' => $request->stock_quantity,
            'image' => $path,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    
    public function edit(Product $product)
    {
        // The ProductPolicy's before() method automatically grants access to admins
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    
    public function update(Request $request, Product $product)
    {
        // The ProductPolicy's before() method automatically grants access to admins
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
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path('app/public/products/' . $filename));
            $path = 'products/' . $filename;
        }

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

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    
    public function destroy(Product $product)
    {
        // The ProductPolicy's before() method automatically grants access to admins
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}


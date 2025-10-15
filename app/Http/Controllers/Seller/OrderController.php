<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get all order items belonging to the seller's products
        $orderItems = auth()->user()->sales()->with('order')->latest()->get();
        return view('orders.index', compact('orderItems'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        // Basic authorization: ensure the product belongs to the seller
        if ($orderItem->product->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['status' => 'required|in:pending,accepted,shipping']);

        $orderItem->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}

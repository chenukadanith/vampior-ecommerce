<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get all orders placed by the current user
        $orders = auth()->user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        // Basic authorization: ensure the order belongs to the buyer
        if ($orderItem->order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($orderItem->status !== 'shipping') {
            return redirect()->back()->with('error', 'You can only complete orders that are currently shipping.');
        }

        $request->validate(['status' => 'required|in:completed']);

        $orderItem->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order marked as completed!');
    }
}


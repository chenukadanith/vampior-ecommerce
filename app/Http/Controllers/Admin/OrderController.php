<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        // Eager load the user (buyer) relationship to prevent N+1 issues
        $orders = Order::with('user')->latest()->get();

        // Calculate some stats for the dashboard
        $totalOrders = $orders->count();
        $totalRevenue = $orders->sum('total');

        return view('admin.orders.index', compact('orders', 'totalOrders', 'totalRevenue'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Eager load all relationships for the detailed view
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }
}


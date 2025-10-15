<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $seller = auth()->user();

        // Get all order items belonging to this seller's products
        $sales = $seller->sales();

        // 1. Calculate Total Revenue (only from 'completed' orders)
        $totalRevenue = (clone $sales)->where('order_items.status', 'completed')
            // MODIFIED: Explicitly specify the table for price and quantity
            ->sum(DB::raw('order_items.price * order_items.quantity'));

        // 2. Calculate Total Units Sold (only from 'completed' orders)
        $unitsSold = (clone $sales)->where('order_items.status', 'completed')
             // MODIFIED: Explicitly specify the quantity column
            ->sum('order_items.quantity');

        // 3. Count Active / Pending Orders
        $pendingOrders = (clone $sales)->whereIn('order_items.status', ['pending', 'accepted', 'shipping'])
            ->count();

        // 4. Get Top 5 Selling Products
        $topProducts = $seller->products()
            ->withCount(['orderItems' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();


        return view('seller.analytics.index', compact(
            'totalRevenue',
            'unitsSold',
            'pendingOrders',
            'topProducts'
        ));
    }
}


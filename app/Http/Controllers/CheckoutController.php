<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('dashboard')->with('info', 'Your cart is empty. Please add products to proceed to checkout.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
        ]);

        $cartItems = session('cart', []);
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();

        try {
            // Create the order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'shipping_name' => $request->name,
                'shipping_address' => $request->address,
                'shipping_city' => $request->city,
                'shipping_postal_code' => $request->postal_code,
            ]);

            // Create order items
            foreach ($cartItems as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            DB::commit();

            // Clear the cart
            session()->forget('cart');

            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            DB::rollBack();
            // Optionally log the error: Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while placing your order. Please try again.');
        }
    }

    /**
     * Display the order success page.
     */
    public function success()
    {
        return view('checkout.success');
    }
}


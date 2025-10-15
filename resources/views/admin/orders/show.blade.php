<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details') }} #{{ $order->id }}
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Back to all orders</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Order & Buyer Info -->
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium text-gray-900">Order Information</h3>
                        <div class="mt-4 space-y-2 text-sm">
                            <p><span class="font-semibold">Order ID:</span> #{{ $order->id }}</p>
                            <p><span class="font-semibold">Date:</span> {{ $order->created_at->format('F j, Y, g:i a') }}</p>
                            <p><span class="font-semibold">Total:</span> <span class="font-bold text-lg">${{ number_format($order->total, 2) }}</span></p>
                            <hr class="my-4">
                            <p class="font-semibold">Buyer:</p>
                            <p>{{ $order->user->name }}</p>
                            <p>{{ $order->user->email }}</p>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="md:col-span-1">
                         <h3 class="text-lg font-medium text-gray-900">Shipping Address</h3>
                         <address class="mt-4 not-italic text-sm text-gray-600">
                            <span class="font-semibold">{{ $order->shipping_name }}</span><br>
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}
                        </address>
                    </div>

                    <!-- Items List -->
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium text-gray-900">Items in this Order</h3>
                        <ul class="mt-4 space-y-4">
                            @foreach($order->items as $item)
                                <li class="flex items-start space-x-4 text-sm">
                                    <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : 'https://placehold.co/100x100' }}" alt="{{ $item->product->title }}" class="h-16 w-16 rounded-md object-cover flex-shrink-0">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800">{{ $item->product->title }}</p>
                                        <p class="text-gray-500">Qty: {{ $item->quantity }} @ ${{ number_format($item->price, 2) }}</p>
                                        <p class="mt-1">
                                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($item->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                                @if($item->status == 'accepted') bg-blue-100 text-blue-800 @endif
                                                @if($item->status == 'shipping') bg-indigo-100 text-indigo-800 @endif
                                                @if($item->status == 'completed') bg-green-100 text-green-800 @endif">
                                                {{ ucfirst($item->status) }}
                                           </span>
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

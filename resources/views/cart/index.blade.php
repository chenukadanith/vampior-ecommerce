<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (count($cartItems) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cartItems as $id => $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        <img class="h-16 w-16 rounded-md object-cover" src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://placehold.co/150x150' }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $item['name'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item['price'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" class="w-20 text-center border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-between items-center">
                            <div>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-gray-600 hover:text-gray-900">Clear Cart</button>
                                </form>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold">Total: <span class="text-indigo-600">${{ number_format($total, 2) }}</span></p>
                                <a href="{{ route('checkout.index') }}" class="mt-2 inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h3 class="text-lg font-medium text-gray-900">Your cart is empty.</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                <a href="{{ route('dashboard') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Continue Shopping &rarr;
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

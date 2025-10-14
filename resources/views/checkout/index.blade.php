<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                    @foreach($cartItems as $item)
                        <div class="flex justify-between items-center py-2 border-b">
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="text-gray-800 font-medium">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center py-4 font-bold text-lg">
                        <p>Total</p>
                        <p>${{ number_format($total, 2) }}</p>
                    </div>

                    <hr class="my-6">

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping & Payment</h3>
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                           Please correct the errors below.
                        </div>
                    @endif

                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <!-- Shipping Details -->
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                 @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Placeholder -->
                        <div class="mt-6 border-t pt-6">
                             <p class="text-sm text-gray-600">Payment processing will be handled by a third-party provider.</p>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-gray-800 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

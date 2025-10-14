<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Image -->
                    <div>
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=No+Image' }}"
                             alt="{{ $product->title }}"
                             class="w-full h-auto rounded-lg shadow-lg"
                             onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/e2e8f0?text=No+Image';">
                    </div>

                    <!-- Product Details -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $product->title }}</h1>
                        <p class="mt-2 text-sm text-gray-500">Category: {{ $product->category }}</p>

                        <p class="mt-4 text-3xl font-extrabold text-indigo-600">${{ number_format($product->price, 2) }}</p>

                        <div class="mt-6">
                            <h3 class="text-sm font-medium text-gray-900">Description</h3>
                            <div class="mt-2 text-base text-gray-600 leading-relaxed">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>

                        <div class="mt-6">
                            @if($product->stock_quantity > 0)
                                <p class="text-sm text-green-600 font-semibold">{{ $product->stock_quantity }} in stock</p>
                            @else
                                <p class="text-sm text-red-600 font-semibold">Out of stock</p>
                            @endif
                        </div>

                        <div class="mt-8">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-800 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 disabled:opacity-50"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    Add to cart
                                </button>
                            </form>
                        </div>

                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


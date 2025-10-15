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
                        <p class="mt-2 text-sm text-gray-500">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>

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

                        <!-- MODIFIED: Action Buttons (Cart & Wishlist) -->
                        <div class="mt-8 flex space-x-4">
                            <!-- Add to Cart Form -->
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-gray-800 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-700 disabled:opacity-50"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                    Add to cart
                                </button>
                            </form>

                            <!-- START: Wishlist Button -->
                            @if(in_array($product->id, $wishlistProductIds))
                                <!-- Product is in wishlist: show Remove button -->
                                <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 border rounded-md text-red-500 bg-red-50 border-red-300 hover:bg-red-100 transition-colors duration-200" title="Remove from Wishlist">
                                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <!-- Product is not in wishlist: show Add button -->
                                <form action="{{ route('wishlist.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="p-3 border rounded-md text-gray-400 hover:text-red-500 hover:bg-red-50 hover:border-red-300 transition-colors duration-200" title="Add to Wishlist">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            <!-- END: Wishlist Button -->
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


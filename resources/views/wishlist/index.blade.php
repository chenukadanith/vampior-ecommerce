<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($wishlistItems->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($wishlistItems as $product)
                        <div class="group relative overflow-hidden rounded-lg bg-white shadow-sm transition-all duration-300 hover:shadow-xl">
                            <a href="{{ route('product.show', $product) }}">
                                <div class="aspect-w-1 aspect-h-1 w-full bg-gray-100">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x400' }}"
                                         alt="{{ $product->title }}"
                                         class="h-full w-full object-cover object-center">
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-medium text-gray-700 truncate">{{ $product->title }}</h3>
                                    <p class="mt-2 text-lg font-semibold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                </div>
                            </a>
                            <!-- Remove from Wishlist Button -->
                            <div class="absolute top-2 right-2">
                                <form action="{{ route('wishlist.remove', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-white/50 rounded-full text-gray-600 hover:text-red-600 hover:bg-white transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p>Your wishlist is empty.</p>
                        <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-800 mt-2 inline-block">Discover products</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>


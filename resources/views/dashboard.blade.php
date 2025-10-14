<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($products->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <a href="{{ route('product.show', $product) }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="relative">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=No+Image' }}"
                                     alt="{{ $product->title }}"
                                     class="w-full h-56 object-cover"
                                     onerror="this.onerror=null;this.src='https://placehold.co/600x400/e2e8f0/e2e8f0?text=No+Image';">
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-gray-900 truncate">{{ $product->title }}</h3>
                                <p class="mt-2 text-xl font-semibold text-indigo-600">${{ number_format($product->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <p>No products have been listed yet. Check back soon!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

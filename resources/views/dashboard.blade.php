<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

         
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row md:items-end md:space-x-3 space-y-3 md:space-y-0">
                        <!-- Category Filter -->
                        <div class="flex-1">
                            <label for="category" class="block text-xs font-medium text-gray-700 mb-1">Category</label>
                            <select id="category" name="category" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Bar -->
                        <div class="flex-1">
                            <label for="search" class="block text-xs font-medium text-gray-700 mb-1">Search Products</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm text-sm border-gray-300 rounded-md pl-10 py-2" placeholder="e.g. Smartphone" value="{{ request('search') }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex-shrink-0">
                             <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END: Filter and Search Form -->


            @if($products->isNotEmpty())
                <!-- UPDATED: Compact and modern grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($products as $product)
                        <div class="group relative flex flex-col bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 border border-gray-200">
                            <a href="{{ route('product.show', $product) }}" class="flex flex-col h-full">
                                <!-- Compact Image -->
                                <div class="relative w-full h-40 bg-gray-50 overflow-hidden">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/400x300/e2e8f0/94a3b8?text=No+Image' }}"
                                        alt="{{ $product->title }}"
                                        class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300" />
                                    <!-- Category Badge -->
                                    <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm text-gray-700 rounded-md px-2 py-1 text-xs font-medium shadow-sm">
                                        <i class="fa fa-tag mr-1 text-indigo-500"></i>{{ $product->category->name ?? 'Uncategorized' }}
                                    </div>
                                </div>
                                
                                <!-- Card Content -->
                                <div class="flex flex-col flex-1 p-3">
                                    <!-- Title and Price -->
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 flex-1">{{ $product->title }}</h3>
                                        <span class="flex-shrink-0 inline-block rounded-md bg-green-50 text-green-700 text-sm px-2 py-1 font-bold whitespace-nowrap">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    
                                    <!-- Description -->
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $product->description }}</p>
                                    
                                    <!-- View Button -->
                                    <div class="mt-auto">
                                        <span class="inline-flex items-center justify-center w-full gap-1.5 px-3 py-2 rounded-md bg-gray-800 text-white text-xs font-medium shadow-sm hover:bg-gray-900 transition-colors group-hover:bg-indigo-600">
                                            <i class="fa fa-eye"></i> View Details
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $products->appends(request()->query())->links() }}
                </div>

            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-base font-medium text-gray-900 mb-2">No products found</p>
                        <p class="text-sm text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
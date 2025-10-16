<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Assign to Seller -->
                        <div class="mb-4">
                            <label for="user_id" class="block font-medium text-sm text-gray-700">{{ __('Assign to Seller') }}</label>
                            <select id="user_id" name="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required>
                                <option value="">Select a Seller</option>
                                @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}" {{ old('user_id') == $seller->id ? 'selected' : '' }}>{{ $seller->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="title" class="block font-medium text-sm text-gray-700">{{ __('Title') }}</label>
                            <input id="title" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="title" value="{{ old('title') }}" required />
                        </div>

                        <div class="mt-4">
                            <label for="description" class="block font-medium text-sm text-gray-700">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="5">{{ old('description') }}</textarea>
                        </div>
                        
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="price" class="block font-medium text-sm text-gray-700">{{ __('Price') }}</label>
                                <input id="price" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="number" name="price" value="{{ old('price') }}" step="0.01" required />
                            </div>
                            <div>
                                <label for="stock_quantity" class="block font-medium text-sm text-gray-700">{{ __('Stock Quantity') }}</label>
                                <input id="stock_quantity" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="category_id" class="block font-medium text-sm text-gray-700">{{ __('Category') }}</label>
                                <select id="category_id" name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="">Select a Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div>
                                <label for="tags" class="block font-medium text-sm text-gray-700">{{ __('Tags (comma separated)') }}</label>
                                <input id="tags" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="tags" value="{{ old('tags') }}" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="image" class="block font-medium text-sm text-gray-700">{{ __('Product Image') }}</label>
                            <input id="image" class="block mt-1 w-full" type="file" name="image">
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.products.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Create Product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

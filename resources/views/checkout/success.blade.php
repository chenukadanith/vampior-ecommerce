<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Placed Successfully') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg leading-6 font-medium text-gray-900">Thank you for your order!</h3>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>Your order has been placed and is being processed.</p>
                        <p>You will receive a confirmation email shortly.</p>
                    </div>
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

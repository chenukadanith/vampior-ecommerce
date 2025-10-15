<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <!-- Top-right navigation -->
            <div class="absolute top-0 right-0 p-6">
                @if (Route::has('login'))
                    <nav class="flex flex-1 justify-end space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>

            <!-- Main Content Card -->
            <main class="w-full max-w-4xl mx-auto p-6 lg:p-8">
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <!-- Left Column: Content -->
                        <div class="p-8 md:p-12 flex flex-col justify-center">
                            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">
                                Welcome to Vampior Designs
                            </h1>
                            <p class="mt-4 text-gray-600">
                                Discover the latest in cutting-edge electronics. From high-performance gadgets to everyday essentials, find everything you need in one place.
                            </p>
                            <div class="mt-8">
                                <a href="{{ route('login') }}" class="inline-block rounded-lg bg-gray-800 px-5 py-3 text-base font-medium text-white transition hover:bg-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-800 focus-visible:ring-offset-2">
                                    Shop Now &rarr;
                                </a>
                            </div>
                        </div>
                        <!-- Right Column: Image -->
                        <div class="hidden md:block">
                            <img src="https://placehold.co/600x600/111827/FFFFFF?text=Featured\nProduct" alt="Featured Product" class="h-full w-full object-cover"/>
                        </div>
                    </div>
                </div>
            </main>

             <!-- Footer -->
            <footer class="py-6 text-center text-sm text-gray-500">
                &copy; 2025 Vampior Designs. All rights reserved.
            </footer>
        </div>
    </body>
</html>


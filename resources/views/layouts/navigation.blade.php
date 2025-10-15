<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Side: Logo and Main Links -->
            <div class="flex items-center">
                <!-- Logo Placeholder -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <svg class="block h-8 w-auto text-gray-800" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="8" fill="currentColor"/>
                            <path d="M12 12H28V28H12V12Z" stroke="white" stroke-width="2"/>
                            <path d="M20 12V28" stroke="white" stroke-width="2"/>
                        </svg>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                       <div class="relative flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="ml-2">{{ __('Cart') }}</span>
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ count(session('cart')) }}</span>
                            @endif
                       </div>
                    </x-nav-link>
                    <x-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')">
                        <div class="relative flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span class="ml-2">{{ __('Wishlist') }}</span>
                            @if(auth()->user()->wishlist()->count() > 0)
                                <span class="absolute -top-2 -right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ auth()->user()->wishlist()->count() }}</span>
                            @endif
                        </div>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: Theme Toggle and Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                 <!-- Theme Toggle Button (UI Only) -->
                <button type="button" class="p-2 mr-2 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Role-based links -->
                        @role('admin')
                            <x-dropdown-link :href="route('admin.users.index')"> {{ __('Manage Users') }} </x-dropdown-link>
                            <x-dropdown-link :href="route('admin.categories.index')"> {{ __('Manage Categories') }} </x-dropdown-link>
                        @endrole
                        @hasanyrole('admin|seller')
                            <x-dropdown-link :href="auth()->user()->hasRole('admin') ? route('admin.products.index') : route('seller.products.index')"> {{ __('Manage Products') }} </x-dropdown-link>
                        @endhasanyrole
                        @hasanyrole('buyer|seller')
                            <x-dropdown-link :href="auth()->user()->hasRole('seller') ? route('seller.orders.index') : route('buyer.orders.index')"> {{ __('My Orders') }} </x-dropdown-link>
                        @endhasanyrole
                        <div class="border-t border-gray-200"></div>
                        <!-- Standard Links -->
                        <x-dropdown-link :href="route('profile.edit')"> {{ __('Profile') }} </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"> {{ __('Home') }} </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"> {{ __('Cart') }} </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.index')"> {{ __('Wishlist') }} </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                @role('admin')
                    <x-responsive-nav-link :href="route('admin.users.index')"> {{ __('Manage Users') }} </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.categories.index')"> {{ __('Manage Categories') }} </x-responsive-nav-link>
                @endrole
                @hasanyrole('admin|seller')
                    <x-responsive-nav-link :href="auth()->user()->hasRole('admin') ? route('admin.products.index') : route('seller.products.index')"> {{ __('Manage Products') }} </x-responsive-nav-link>
                @endhasanyrole
                @hasanyrole('buyer|seller')
                    <x-responsive-nav-link :href="auth()->user()->hasRole('seller') ? route('seller.orders.index') : route('buyer.orders.index')"> {{ __('My Orders') }} </x-responsive-nav-link>
                @endhasanyrole
                <x-responsive-nav-link :href="route('profile.edit')"> {{ __('Profile') }} </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


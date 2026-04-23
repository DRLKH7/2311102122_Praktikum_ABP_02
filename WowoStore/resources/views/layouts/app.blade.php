<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WowoStore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Icons -->
        <script src="https://unpkg.com/@phosphor-icons/web"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
        </style>
    </head>
    <body class="h-full antialiased bg-slate-50 text-slate-900">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                   class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-slate-300 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex flex-col h-full">
                    <!-- Sidebar Header -->
                    <div class="flex items-center justify-center h-20 px-6 border-b border-slate-800">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-600 rounded-xl">
                                <i class="ph-bold ph-store-front text-2xl text-white"></i>
                            </div>
                            <span class="text-xl font-bold text-white tracking-tight">WowoStore</span>
                        </div>
                    </div>

                    <!-- Sidebar Nav -->
                    <nav class="flex-1 px-4 py-6 overflow-y-auto space-y-2">
                        <a href="{{ route('dashboard') }}" 
                           class="{{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}">
                            <i class="ph-bold ph-squares-four text-xl"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('products.index') }}" 
                           class="{{ request()->routeIs('products.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
                            <i class="ph-bold ph-package text-xl"></i>
                            <span class="font-medium">Inventory</span>
                        </a>

                        <div class="pt-6 pb-2 text-xs font-semibold text-slate-500 uppercase tracking-widest px-4">
                            System
                        </div>

                        <a href="{{ route('profile.edit') }}" 
                           class="{{ request()->routeIs('profile.edit') ? 'sidebar-link-active' : 'sidebar-link' }}">
                            <i class="ph-bold ph-user-circle text-xl"></i>
                            <span class="font-medium">Profile</span>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full sidebar-link">
                                <i class="ph-bold ph-sign-out text-xl"></i>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </nav>

                    <!-- Sidebar Footer -->
                    <div class="p-4 border-t border-slate-800">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-900 border border-slate-800">
                            <div class="w-10 h-10 rounded-lg bg-indigo-500 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">© 2024 WowoStore</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex flex-col flex-1 w-full overflow-hidden">
                <!-- Topbar -->
                <header class="flex items-center justify-between h-20 px-8 bg-white border-b border-slate-200">
                    <div class="flex items-center gap-4 lg:hidden">
                        <button @click="sidebarOpen = true" class="p-2 text-slate-500 rounded-lg hover:bg-slate-100 transition-colors">
                            <i class="ph-bold ph-list text-2xl"></i>
                        </button>
                    </div>

                    <div class="hidden md:block">
                        <h2 class="text-2xl font-bold text-slate-800">
                            @yield('header_title', 'Welcome back!')
                        </h2>
                    </div>

                    <div class="flex items-center gap-4">
                        <form action="{{ route('products.index') }}" method="GET" class="relative hidden sm:block">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="ph-bold ph-magnifying-glass"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-10 pr-4 py-2 bg-slate-100 border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 transition-all w-64" placeholder="Search products everywhere...">
                        </form>
                        
                        <button class="p-2 text-slate-500 rounded-xl hover:bg-slate-100 transition-colors relative">
                            <i class="ph-bold ph-bell text-2xl"></i>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                        </button>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-8">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" 
                             class="mb-8 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl">
                             <div class="flex items-center gap-3">
                                <i class="ph-fill ph-check-circle text-2xl"></i>
                                <span class="font-medium">{{ session('success') }}</span>
                             </div>
                             <button @click="show = false"><i class="ph ph-x"></i></button>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>

            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 class="fixed inset-0 z-40 bg-slate-900 bg-opacity-50 lg:hidden transition-opacity duration-300"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            </div>
        </div>
    </body>
</html>

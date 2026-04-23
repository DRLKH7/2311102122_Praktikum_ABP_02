<x-app-layout>
    @section('header_title', 'Warehouse Inventory')

    <div class="space-y-6">
        <!-- Action Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4 flex-1">
                <!-- Per Page Select -->
                <form action="{{ route('products.index') }}" method="GET" id="filterForm" class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Show</span>
                        <select name="per_page" onchange="this.form.submit()" 
                                class="pl-3 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                            @foreach([10, 20, 30, 40, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">Category</span>
                        <select name="category" onchange="this.form.submit()" 
                                class="pl-3 pr-8 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm min-w-[150px]">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Box -->
                    <div class="relative w-full max-w-sm">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="ph-bold ph-magnifying-glass"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                    </div>
                    
                    <button type="submit" class="hidden">Search</button>
                    
                    @if(request()->hasAny(['search', 'category', 'per_page']))
                        <a href="{{ route('products.index') }}" class="p-2.5 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-colors shadow-sm" title="Clear Filters">
                            <i class="ph-bold ph-x text-xl"></i>
                        </a>
                    @endif
                </form>
            </div>

            <a href="{{ route('products.create') }}" class="btn-primary flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="ph-bold ph-plus"></i>
                <span>Add New Product</span>
            </a>
        </div>

        <!-- Inventory Table -->
        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Product Info</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Stock Level</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold transition-transform group-hover:scale-110">
                                        <i class="ph-bold ph-cube"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 text-lg leading-tight">{{ $product->name }}</span>
                                        <span class="text-sm text-slate-500 line-clamp-1 max-w-xs mt-1">{{ $product->description ?: 'No description provided.' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold border border-slate-200">
                                    {{ $product->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-center gap-2">
                                    @php
                                        $stockClass = $product->stock < 10 ? 'bg-rose-500' : ($product->stock < 30 ? 'bg-amber-500' : 'bg-emerald-500');
                                        $stockPercent = min(($product->stock / 100) * 100, 100);
                                    @endphp
                                    <div class="flex items-center justify-between w-32 mb-1">
                                        <span class="text-xs font-bold text-slate-600">{{ $product->stock }} units</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                            {{ $product->stock < 10 ? 'Low' : 'Stable' }}
                                        </span>
                                    </div>
                                    <div class="w-32 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="{{ $stockClass }} h-full transition-all duration-1000" style="width: {{ $stockPercent }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">IDR Currency</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 text-slate-400">
                                    <a href="{{ route('products.edit', $product) }}" class="p-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all" title="Edit Product">
                                        <i class="ph-bold ph-pencil-simple text-xl"></i>
                                    </a>
                                    
                                    <button @click="$dispatch('open-modal', 'delete-{{ $product->id }}')" class="p-2.5 rounded-xl hover:bg-rose-50 hover:text-rose-600 transition-all" title="Delete Product">
                                        <i class="ph-bold ph-trash text-xl"></i>
                                    </button>

                                    <!-- Improved Delete Modal -->
                                    <x-modal name="delete-{{ $product->id }}" focusable>
                                        <div class="p-8 bg-white text-slate-900 rounded-3xl overflow-hidden relative text-left">
                                            <div class="absolute -top-12 -right-12 w-48 h-48 bg-rose-50 rounded-full"></div>
                                            
                                            <div class="relative z-10 text-center">
                                                <div class="w-20 h-20 bg-rose-100 text-rose-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                                    <i class="ph-bold ph-warning text-4xl"></i>
                                                </div>
                                                <h2 class="text-2xl font-bold text-slate-900 mb-2">Delete Product?</h2>
                                                <p class="text-slate-500 mb-8 max-w-xs mx-auto">
                                                    You are about to delete <span class="font-bold text-slate-800">{{ $product->name }}</span>. This action cannot be undone.
                                                </p>

                                                <form method="post" action="{{ route('products.destroy', $product) }}" class="flex flex-col gap-3">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="w-full py-4 bg-rose-600 text-white rounded-2xl font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-200">
                                                        Yes, Delete Item
                                                    </button>
                                                    <button type="button" @click="$dispatch('close')" class="w-full py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                                                        Cancel
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </x-modal>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center gap-4 text-slate-400">
                                    <i class="ph ph-mask-sad text-6xl"></i>
                                    <p class="text-lg font-medium italic">No products found matching your criteria.</p>
                                    <a href="{{ route('products.index') }}" class="text-indigo-600 font-bold underline">Clear all filters</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Custom Pagination -->
            @if($products->hasPages())
            <div class="px-6 py-5 border-t border-slate-100 bg-slate-50/50">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    @section('header_title', 'Inventory Analysis')

    <div class="space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card-premium p-6 flex items-center gap-6">
                <div class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <i class="ph-fill ph-package text-3xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Products</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalProducts) }}</h3>
                </div>
            </div>

            <div class="card-premium p-6 flex items-center gap-6">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <i class="ph-fill ph-stack text-3xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Stock</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($totalStock) }}</h3>
                </div>
            </div>

            <div class="card-premium p-6 flex items-center gap-6">
                <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl">
                    <i class="ph-fill ph-warning-circle text-3xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Low Stock</p>
                    <h3 class="text-3xl font-bold text-slate-900">{{ number_format($lowStockCount) }}</h3>
                    @if($lowStockCount > 0)
                    <p class="text-xs text-rose-500 font-medium mt-1 animate-pulse">Action required immediately</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="card-premium overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-800 text-lg">Recently Added Products</h3>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View All Inventory →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Product Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Current Stock</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Unit Price</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Added At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentProducts as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600">
                                        <i class="ph ph-box-archive"></i>
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $product->stock < 10 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ $product->stock }} in units
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm text-right">{{ $product->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

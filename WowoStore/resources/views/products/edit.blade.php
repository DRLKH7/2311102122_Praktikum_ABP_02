<x-app-layout>
    @section('header_title', 'Modify Product')

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 mb-6 font-medium transition-colors group">
            <i class="ph ph-arrow-left transition-transform group-hover:-translate-x-1"></i>
            Back to Inventory
        </a>

        <div class="card-premium">
            <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 leading-none">Edit: {{ $product->name }}</h3>
                    <p class="text-slate-500 text-sm mt-2">Update the information for this product below.</p>
                </div>
                <div class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">ID Record</span>
                    <span class="font-mono text-sm text-slate-600">#PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            <form action="{{ route('products.update', $product) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2 text-[11px]">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400"
                           placeholder="e.g. Logitech G Pro X Wireless">
                    @error('name') <p class="mt-1 text-xs text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2 text-[11px]">Category</label>
                    <select name="category" id="category" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        <option value="Monitor" {{ old('category', $product->category) == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                        <option value="Laptop" {{ old('category', $product->category) == 'Laptop' ? 'selected' : '' }}>Laptop</option>
                        <option value="SSD/Storage" {{ old('category', $product->category) == 'SSD/Storage' ? 'selected' : '' }}>SSD/Storage</option>
                        <option value="Keyboard" {{ old('category', $product->category) == 'Keyboard' ? 'selected' : '' }}>Keyboard</option>
                        <option value="Cables/Accessories" {{ old('category', $product->category) == 'Cables/Accessories' ? 'selected' : '' }}>Cables/Accessories</option>
                        <option value="Bracket/Mount" {{ old('category', $product->category) == 'Bracket/Mount' ? 'selected' : '' }}>Bracket/Mount</option>
                        <option value="GPU" {{ old('category', $product->category) == 'GPU' ? 'selected' : '' }}>GPU</option>
                    </select>
                    @error('category') <p class="mt-1 text-xs text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2 text-[11px]">Description (Optional)</label>
                    <textarea name="description" id="description" rows="4" 
                              class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder:text-slate-400"
                              placeholder="Describe your product features, warranty, or condition...">{{ old('description', $product->description) }}</textarea>
                    @error('description') <p class="mt-1 text-xs text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2 text-[11px]">Purchase Price (IDR)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-bold border-r pr-3 border-slate-200">Rp</span>
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" 
                                   class="w-full pl-16 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                   placeholder="0">
                        </div>
                        @error('price') <p class="mt-1 text-xs text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-bold text-slate-700 uppercase tracking-wider mb-2 text-[11px]">Revised Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" 
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                               placeholder="0">
                        @error('stock') <p class="mt-1 text-xs text-rose-500 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                        <i class="ph-bold ph-floppy-disk"></i>
                        Save Changes
                    </button>
                    <a href="{{ route('products.index') }}" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                        Discard
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

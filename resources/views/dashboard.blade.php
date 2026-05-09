<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="chalkboard-container shadow-2xl relative p-12" style="border: 12px solid #3d2b1f; background-color: #1a2e26;">
                
                <div class="flex justify-between items-end mb-16 border-b-4 border-double border-white/20 pb-6">
                    <div>
                        <h1 class="text-5xl text-yellow-400 uppercase tracking-tighter font-black" style="text-shadow: 3px 3px #000;">
                            Problem Solver Surplus
                        </h1>
                        <p class="text-gray-400 font-mono text-sm mt-2 tracking-widest uppercase">Inventory Management System // v1.0</p>
                    </div>
                
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('products.create') }}" class="pixel-btn transform hover:scale-105 transition-transform" style="padding: 15px 25px;">
                            [+] LOG NEW SUPPLY
                        </a>
                    @endif
                </div>

                <div class="mb-8 p-4 bg-black/40 border-2 border-gray-600">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap items-center gap-4">
                        
                        <div class="flex flex-col">
                            <label class="text-yellow-400 font-mono text-xs uppercase mb-1">Filter Type</label>
                            <select name="category_id" onchange="this.form.submit()" 
                                    class="bg-white font-bold border-2 border-gray-400 p-2" 
                                    style="color: #059669 !important;">
                                <option value="">All Collections</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-yellow-400 font-mono text-xs uppercase mb-1">Sort By</label>
                            <select name="sort" onchange="this.form.submit()" 
                                    class="bg-white font-bold border-2 border-gray-400 p-2" 
                                    style="color: #059669 !important;">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock Level</option>
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Latest Entry</option>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-yellow-400 font-mono text-xs uppercase mb-1">Order</label>
                            <select name="direction" onchange="this.form.submit()" 
                                    class="bg-white font-bold border-2 border-gray-400 p-2" 
                                    style="color: #059669 !important;">
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>

                        <div class="flex items-end h-full mt-5">
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-yellow-400 font-mono text-xs uppercase underline">
                                [ Clear Filters ]
                            </a>
                        </div>
                    </form>
                </div>

                <div class="space-y-12">
                    @forelse ($products as $p)
                    <div class="product-shelf-row border-b-2 border-dashed border-white/30 pb-10 mb-10 flex space-x-12 items-start">
                        
                        <div class="flex-shrink-0">
                            <div style="width: 160px; height: 160px;" class="bg-black/60 border-4 border-white flex items-center justify-center overflow-hidden shadow-[5px_5px_0px_0px_rgba(255,255,255,0.2)]">
                                @if($p->image_path)
                                    <img src="{{ asset('storage/' . $p->image_path) }}" 
                                         alt="{{ $p->name }}" 
                                         style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                         class="pixelated-img">
                                @else
                                    <span class="text-xs text-gray-500 uppercase tracking-widest text-center px-2">No Visual Model</span>
                                @endif
                            </div>

                            @if(Auth::user()->role === 'admin')
                                <div class="mt-4 flex flex-col space-y-2" style="width: 160px;">
                                    <a href="{{ route('products.edit', $p->id) }}" class="pixel-btn text-center text-xs py-1">EDIT DATA</a>
                                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('De-list this supply?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="pixel-btn w-full text-xs py-1" style="background: #ff4444;">[X] DELETE</button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-4xl text-white font-bold mb-4 uppercase tracking-wide">
                                {{ $p->name }}
                            </h3>
                            
                            <div class="flex space-x-12 mb-6">
                                <div class="bg-white/5 border-l-4 border-green-400 px-4 py-2">
                                    <p class="text-gray-400 text-xs uppercase font-mono">Current Value</p>
                                    <span class="text-green-400 text-3xl font-black">${{ number_format($p->price, 2) }}</span>
                                </div>
                                <div class="bg-white/5 border-l-4 border-yellow-400 px-4 py-2">
                                    <p class="text-gray-400 text-xs uppercase font-mono">Stock Level</p>
                                    <span class="text-white text-3xl font-bold">{{ $p->stock }} <small class="text-sm text-gray-400">UNITS</small></span>
                                </div>
                            </div>

                            @if($p->description)
                                <div class="relative bg-black/20 p-4 border-l-2 border-white/20">
                                    <p class="text-gray-300 text-lg font-sans italic leading-relaxed">
                                        "{{ $p->description }}"
                                    </p>
                                </div>
                            @else
                                <p class="text-gray-600 italic text-sm">-- No further data logs available --</p>
                            @endif
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-20">
                            <p class="text-gray-500 text-2xl font-mono uppercase tracking-[0.5em]">Inventory Depleted</p>
                        </div>
                    @endforelse
                </div>
            </div> 
        </div>
    </div>
</x-app-layout>
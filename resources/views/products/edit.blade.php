<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="chalkboard-container shadow-2xl relative p-8" style="border: 10px solid #3d2b1f; background-color: #1a2e26;">
                <h1 class="text-4xl text-yellow-400 uppercase tracking-widest mb-8" style="text-shadow: 2px 2px #000;">
                    Update Supply: {{ $product->name }}
                </h1>

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-2xl text-white mb-2 font-mono uppercase">Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="w-full bg-white border-2 border-gray-400 p-3 text-xl focus:outline-none" style="color: #059669 !important; font-weight: bold;" required>
                    </div>

                    <div class="flex space-x-8">
                        <div class="flex-1">
                            <label class="block text-2xl text-white mb-2 font-mono uppercase">Price ($)</label>
                            <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full bg-white border-2 border-gray-400 p-3 text-xl shadow-inner" style="color: #059669 !important; font-weight: bold;" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-2xl text-white mb-2 font-mono uppercase">Stock</label>
                            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full bg-white border-2 border-gray-400 p-3 text-xl shadow-inner" style="color: #059669 !important; font-weight: bold;" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-2xl text-white mb-2 font-mono uppercase">Category</label>
                        <select name="category_id" class="w-full bg-white border-2 border-gray-400 p-3 text-xl shadow-inner font-bold" style="color: #059669 !important;">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-2xl text-white mb-2 font-mono uppercase">Supply Lore / Warnings</label>
                        <textarea name="description" rows="3" class="w-full bg-white border-2 border-gray-400 p-3 text-lg focus:outline-none shadow-inner" style="color: #059669 !important; font-weight: bold;">{{ $product->description }}</textarea>
                    </div>

                    <div class="pt-4">
                        <label class="block text-white mb-2 uppercase font-mono text-sm">Current Visual Model</label>
                        @if($product->image_path)
                            <div class="w-32 h-32 bg-black/40 border-2 border-white mb-4 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/' . $product->image_path) }}" class="max-w-full max-h-full object-contain">
                            </div>
                        @endif
                        <label class="block text-yellow-400 text-xs mb-2 uppercase">Upload New Model (Optional)</label>
                        <input type="file" name="image" class="text-white font-mono text-sm">
                    </div>

                    <div class="flex space-x-4 pt-6 border-t border-white/10">
                        <button type="submit" class="pixel-btn">CONFIRM CHANGES</button>
                        <a href="{{ route('dashboard') }}" class="pixel-btn" style="background: #666;">ABORT</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
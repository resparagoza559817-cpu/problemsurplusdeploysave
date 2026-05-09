<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="chalkboard-container shadow-2xl p-8" style="border: 10px solid #3d2b1f; background-color: #1a2e26;">
                <h1 class="text-4xl text-yellow-400 uppercase tracking-widest mb-8" style="text-shadow: 2px 2px #000;">[+] Log New Supply</h1>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-2xl text-white mb-2 font-mono uppercase">Item Name</label>
                        <input type="text" name="name" class="w-full bg-white border-2 border-gray-400 p-3 text-xl focus:outline-none shadow-inner" style="color: #059669 !important; font-weight: bold;" placeholder="Enter name..." required>
                    </div>

                    <div class="flex space-x-8">
                        <div class="flex-1">
                            <label class="block text-2xl text-white mb-2 font-mono uppercase">Price ($)</label>
                            <input type="number" name="price" step="0.01" class="w-full bg-white border-2 border-gray-400 p-3 text-xl shadow-inner" style="color: #059669 !important; font-weight: bold;" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-2xl text-white mb-2 font-mono uppercase">Stock</label>
                            <input type="number" name="stock" class="w-full bg-white border-2 border-gray-400 p-3 text-xl shadow-inner" style="color: #059669 !important; font-weight: bold;" required>
                        </div>
                    </div>

                    <div>
    <label class="block text-2xl text-white mb-2 font-mono uppercase">Category</label>
    <div class="flex space-x-2">
        <select name="category_id" class="w-full bg-white border-2 border-gray-400 p-3 text-xl shadow-inner font-bold" style="color: #059669 !important;">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <a href="{{ route('categories.index') }}" class="pixel-btn flex items-center justify-center" style="background: #fbbf24; width: 60px; color: black;">+</a>
    </div>
</div>

                    <div>
                        <label class="block text-2xl text-white mb-2 font-mono uppercase">Details / Warnings</label>
                        <textarea name="description" rows="3" class="w-full bg-white border-2 border-gray-400 p-3 text-lg focus:outline-none shadow-inner" style="color: #059669 !important; font-weight: bold;" placeholder="Type info here..."></textarea>
                    </div>

                    <div>
                        <label class="block text-2xl text-white mb-2 font-mono uppercase">Visual Model</label>
                        <div id="drop-zone" class="w-full h-32 border-4 border-dashed border-green-500 flex flex-col items-center justify-center cursor-pointer hover:bg-black/40 transition">
                            <span class="text-green-500 font-bold uppercase">Click or Drag Image</span>
                            <input type="file" name="image" id="file-input" class="hidden" accept="image/*">
                        </div>
                        <div id="preview-container" class="mt-4 hidden text-center">
                            <img id="image-preview" src="#" class="h-40 border-4 border-white mx-auto shadow-lg object-contain bg-black/20">
                        </div>
                    </div>

                    <div class="flex space-x-4 pt-6">
                        <button type="submit" class="pixel-btn">Confirm Record</button>
                        <a href="{{ route('dashboard') }}" class="pixel-btn" style="background: #ff4444;">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const dz = document.getElementById('drop-zone');
        const fi = document.getElementById('file-input');
        dz.addEventListener('click', () => fi.click());
        fi.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
</x-app-layout>
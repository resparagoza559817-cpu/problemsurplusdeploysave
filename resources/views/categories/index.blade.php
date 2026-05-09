<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="chalkboard-container shadow-2xl p-8" style="border: 10px solid #3d2b1f; background-color: #1a2e26;">
                
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-4xl text-yellow-400 uppercase tracking-widest" style="text-shadow: 2px 2px #000;">Collection Manager</h1>
                    <a href="{{ route('dashboard') }}" class="pixel-btn" style="background: #666; font-size: 0.8rem;">Back to Logs</a>
                </div>

                <form action="{{ route('categories.store') }}" method="POST" class="mb-10 p-6 bg-black/30 border-2 border-dashed border-gray-500">
                    @csrf
                    <label class="block text-white uppercase font-mono text-xl mb-4">Add New Collection Type</label>
                    <div class="flex space-x-4">
                        <input type="text" name="name" placeholder="e.g. Plushies, Figures..." 
                               class="flex-1 bg-white border-2 border-gray-400 p-3 text-xl focus:outline-none" 
                               style="color: #059669 !important; font-weight: bold;" required>
                        <button type="submit" class="pixel-btn" style="background: #fbbf24; color: black;">Register</button>
                    </div>
                </form>

                <div class="space-y-4">
                    <h2 class="text-2xl text-white font-mono uppercase border-b border-white/20 pb-2">Existing Categories</h2>
                    @foreach($categories as $category)
                        <div class="flex justify-between items-center bg-white/10 p-4 border border-white/5 hover:bg-white/20 transition">
                            <span class="text-2xl text-white font-mono uppercase">{{ $category->name }}</span>
                            
                            @if($category->name !== 'General')
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-300 font-bold uppercase tracking-tighter" 
                                            onclick="return confirm('Archive this collection type?')">
                                        [ Delete ]
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500 italic text-sm uppercase">Protected Default</span>
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <style>
        .admin-body {
            background: url('/bgbgbg2.png') no-repeat center center fixed;
            background-size: cover; 
            height: calc(100vh - 65px);
            display: flex; 
            justify-content: center; 
            font-family: "Comic Sans MS", cursive !important;
            overflow: hidden;
        }
        .inventory-frame {
            width: 98%; 
            max-width: 1100px; 
            height: 90vh;
            background: url('/BlankChalk.png') no-repeat center center;
            background-size: 100% 100%; 
            padding: 40px 60px;
            display: flex; 
            flex-direction: column;
            box-sizing: border-box;
            position: relative;
        }
        .chalk-title { 
            color: #22c55e !important; 
            text-shadow: 2px 2px 0px #000; 
            font-weight: 900; 
        }
        
        .scroll-area {
            flex-grow: 1;
            overflow-y: auto;
            margin-top: 15px;
            padding-bottom: 120px; /* Massive cushion to stop the bottom cutoff */
        }

        .product-row {
            background: rgba(0,0,0,0.4); 
            border-bottom: 1px dashed rgba(255,255,255,0.2);
            padding: 10px; 
            margin-bottom: 6px; 
            display: grid;
            /* RE-ALIGNED GRID: Removed Category column */
            grid-template-columns: 60px 3fr 1fr 80px 140px;
            align-items: center; 
            gap: 20px; 
            color: white;
        }
        
        .pixel-btn { 
            background: #facc15; color: black; padding: 4px 10px; 
            font-size: 12px; border: 2px solid black; font-weight: bold;
            box-shadow: 2px 2px 0px #000;
        }
        .pixel-btn-tiny { 
            font-size: 10px; padding: 4px 8px; border: 1px solid black; 
            color: white; text-align: center; font-weight: bold; 
            box-shadow: 1px 1px 0px #000;
        }
    </style>

    <div class="admin-body">
        <div class="inventory-frame">
            <div class="flex justify-between items-center border-b-2 border-white/20 pb-2">
                <h1 class="text-3xl uppercase italic chalk-title">Inventory Management</h1>
                <div class="flex gap-2">
                    <a href="{{ route('products.create') }}" class="pixel-btn">ADD ITEM</a>
                    <a href="{{ route('categories.index') }}" class="pixel-btn" style="background: white;">CATEGORIES</a>
                </div>
            </div>

            <div class="scroll-area">
                <div class="product-row font-bold text-yellow-400 border-b-2 border-yellow-400/30 mb-2" style="background: none;">
                    <div>IMG</div>
                    <div>ITEM & LORE</div>
                    <div>PRICE</div>
                    <div>STOCK</div>
                    <div class="text-right">MANAGEMENT</div>
                </div>

                @foreach($products as $p)
                <div class="product-row">
                    <div class="h-12 w-12 bg-white/10 border border-white/20 overflow-hidden">
                        @if($p->image_path) 
                            <img src="{{ asset('storage/' . $p->image_path) }}" class="w-full h-full object-contain"> 
                        @endif
                    </div>

                    <div class="min-w-0">
                        <div class="font-bold text-sm truncate uppercase text-white">{{ $p->name }}</div>
                        <div class="text-[10px] opacity-60 truncate italic">{{ $p->description ?? 'No extra lore provided.' }}</div>
                    </div>

                    <div class="font-bold text-sm text-green-400">₱{{ number_format($p->price, 2) }}</div>

                    <div class="text-sm {{ $p->stock <= 5 ? 'text-red-500 font-bold animate-pulse' : '' }}">
                        {{ $p->stock }}
                    </div>

                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('products.edit', $p) }}" class="pixel-btn-tiny bg-blue-600 uppercase hover:bg-blue-700">Modify</a>
                        <form action="{{ route('products.destroy', $p) }}" method="POST" onsubmit="return confirm('DELETE THIS SUPPLY RECORD?')">
                            @csrf @method('DELETE')
                            <button class="pixel-btn-tiny bg-red-600 uppercase hover:bg-red-900">Void</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
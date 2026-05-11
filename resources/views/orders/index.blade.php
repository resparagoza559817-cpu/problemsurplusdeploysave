<x-app-layout>
    <style>
        .admin-body {
            background: url('/bgbgbg2.png') no-repeat center center fixed;
            background-size: cover; height: calc(100vh - 65px);
            display: flex; justify-content: center; font-family: "Comic Sans MS", cursive !important;
            overflow: hidden;
        }
        .history-frame {
            width: 98%; max-width: 1100px; height: 90vh;
            background: url('/BlankChalk.png') no-repeat center center;
            background-size: 100% 100%; padding: 40px 60px;
            display: flex; flex-direction: column; box-sizing: border-box;
        }
        .chalk-title { color: #22c55e !important; text-shadow: 2px 2px 0px #000; font-weight: 900; }
        .scroll-area { flex-grow: 1; overflow-y: auto; margin-top: 15px; padding-bottom: 40px; }
        .scroll-area::-webkit-scrollbar { width: 8px; }
        .scroll-area::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }

        .history-header {
            display: grid; grid-template-columns: 120px 1fr 120px 120px 100px;
            gap: 15px; padding: 10px; border-bottom: 2px solid white;
            color: #facc15; font-weight: bold; text-transform: uppercase; font-size: 12px;
        }
        .history-row {
            display: grid; grid-template-columns: 120px 1fr 120px 120px 100px;
            gap: 15px; padding: 12px 10px; border-bottom: 1px dashed rgba(255,255,255,0.2);
            color: white; align-items: center;
        }
        .pixel-btn-tiny {
            border: 2px solid black; box-shadow: 2px 2px 0px black;
            font-weight: bold; padding: 2px 8px; font-size: 10px; color: white; text-align: center;
        }
    </style>

    <div class="admin-body">
        <div class="history-frame">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl chalk-title uppercase tracking-tighter">Sales History</h1>
                <a href="{{ route('pos.index') }}" class="pixel-btn-tiny bg-gray-600 uppercase">Back to POS</a>
            </div>

            <div class="history-header mt-4">
                <div>Date</div>
                <div>Items Purchased</div>
                <div>Total</div>
                <div>Cashier</div>
                <div>Actions</div>
            </div>

            <div class="scroll-area">
                @foreach($orders as $order)
                <div class="history-row">
                    <div class="text-xs">
                        {{ $order->created_at->format('M d, Y') }}<br>
                        <span class="opacity-50 text-[10px]">{{ $order->created_at->format('h:i A') }}</span>
                    </div>
                    
                    <div class="text-xs">
                        @php $items = json_decode($order->items_json, true); @endphp
                        @if(is_array($items))
                            @foreach($items as $item)
                                <div class="truncate">
                                    <span class="text-yellow-400 font-bold">{{ $item['quantity'] }}x</span> {{ $item['name'] }}
                                </div>
                            @endforeach
                        @else
                            <span class="text-red-400 italic text-[10px]">No item data found</span>
                        @endif
                    </div>

                    <div class="font-bold text-green-400">₱{{ number_format($order->total_amount, 2) }}</div>
                    <div class="text-xs uppercase opacity-80">{{ $order->user->name ?? 'System' }}</div>

                    <div>
                        @if(Auth::user()->role === 'admin')
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="pixel-btn-tiny bg-red-600 uppercase w-full">Delete</button>
                            </form>
                        @else
                            <span class="text-[10px] opacity-30 italic">Locked</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <style>
        .dashboard-body {
            background: url('/bgbgbg2.png') no-repeat center center fixed !important;
            background-size: cover !important;
            height: 100vh;
            overflow: hidden;
            font-family: "Comic Sans MS", cursive !important;
        }

        .history-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
            padding: 20px;
        }

        /* The Blackboard Container */
        .blackboard-container {
            width: 100%;
            max-width: 1100px;
            background: url('/BlankChalk.png') no-repeat center center;
            background-size: 100% 100%;
            padding: 60px 50px;
            height: 80vh;
            display: flex;
            flex-direction: column;
        }

        .chalk-title {
            color: white;
            text-shadow: 2px 2px black;
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Scrollable Table Area */
        .table-scroll {
            flex-grow: 1;
            overflow-y: auto;
            padding-right: 15px;
        }

        /* Custom Scrollbar for Blackboard */
        .table-scroll::-webkit-scrollbar { width: 8px; }
        .table-scroll::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.1); }
        .table-scroll::-webkit-scrollbar-thumb { background: white; border-radius: 4px; }

        .chalk-table {
            width: 100%;
            border-collapse: collapse;
            color: white;
        }

        .chalk-table th {
            position: sticky;
            top: 0;
            background: rgba(0, 0, 0, 0.9);
            padding: 12px;
            border-bottom: 2px solid white;
            text-align: left;
            text-transform: uppercase;
            font-size: 0.9rem;
            z-index: 10;
        }

        .chalk-table td {
            padding: 12px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.3);
            font-size: 1.1rem;
        }

        .row-hover:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .chalk-cyan { color: #00ffff !important; }
        .chalk-green { color: #00ff00 !important; font-weight: bold; }
        .chalk-yellow { color: #fff176 !important; }

        .btn-delete {
            background: #f44336;
            color: white;
            border: 2px solid black;
            padding: 4px 8px;
            font-size: 10px;
            font-weight: bold;
            cursor: pointer;
            text-transform: uppercase;
        }
    </style>

    <div class="dashboard-body">
        <div class="history-wrapper">
            <div class="blackboard-container">
                <h1 class="chalk-title">Sales History</h1>

                <div class="table-scroll">
                    <table class="chalk-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Clerk</th>
                                <th>Method</th>
                                <th>Date</th>
                                @if(Auth::user()->role === 'admin')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="row-hover">
                                    <td class="chalk-cyan">#{{ $order->id }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td class="chalk-green">${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="chalk-yellow">{{ $order->user->name ?? 'System' }}</td>
                                    <td style="font-size: 0.8rem;">{{ strtoupper($order->payment_method) }}</td>
                                    <td class="text-gray-400" style="font-size: 0.8rem;">
                                        {{ $order->created_at->format('M d, Y H:i') }}
                                    </td>
                                    @if(Auth::user()->role === 'admin')
                                        <td>
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Erase from record?')">
                                                @csrf @method('DELETE')
                                                <button class="btn-delete">DELETE</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
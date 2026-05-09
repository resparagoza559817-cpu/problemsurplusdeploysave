<x-app-layout>
    <style>
        /* General Theme Styling */
        .dashboard-body {
            background: url('/bgbgbg2.png') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            overflow: hidden;
            font-family: "Comic Sans MS", cursive !important;
        }

        .pos-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            gap: 25px;
            padding: 20px;
        }

        /* LEFT PANEL: POS & Checkout */
        .left-panel {
            width: 420px;
            background: white;
            border: 6px solid black;
            display: flex;
            flex-direction: column;
            height: 85vh;
            box-shadow: 10px 10px 0px rgba(0,0,0,0.2);
        }

        .clerk-header {
            padding: 15px;
            border-bottom: 6px solid black;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            background: #eee;
        }

        .input-section { padding: 15px; border-bottom: 4px solid black; }
        
        .pos-input {
            width: 100%;
            border: 3px solid black;
            margin-bottom: 10px;
            font-size: 1.1rem;
            padding: 10px;
        }

        .cart-area {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            border-bottom: 4px solid black;
            background: #fafafa;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            border-bottom: 2px dashed #ccc;
            padding: 5px 0;
        }

        .total-box { padding: 15px; background: white; }

        .price-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .change-display {
            background: #fff59d;
            border: 3px dashed black;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .btn-process {
            width: 100%;
            background: #bbbbbb;
            border: 4px solid black;
            padding: 18px;
            font-weight: bold;
            font-size: 1.3rem;
            cursor: pointer;
            text-transform: uppercase;
            transition: 0.2s;
        }

        .btn-process.active {
            background: #4caf50;
            color: white;
        }

        /* RIGHT PANEL: Blackboard Menu */
        .right-panel {
            width: 750px;
            background: url('/BlankChalk.png') no-repeat center center;
            background-size: 100% 100%;
            height: 85vh;
            padding: 60px 50px;
            overflow-y: auto;
        }

        .product-card {
            background: rgba(0, 0, 0, 0.85);
            border: 3px solid white;
            margin-bottom: 20px;
            display: flex;
            padding: 15px;
            color: white;
            gap: 20px;
        }

        .product-card img {
            width: 110px;
            height: 110px;
            border: 2px solid white;
            object-fit: cover;
        }

        .prod-title { font-size: 1.6rem; font-weight: bold; text-transform: uppercase; }
        .prod-desc { color: #00ffff; font-size: 0.95rem; margin-bottom: 8px; }
        .prod-price { color: #0f0; font-size: 1.8rem; font-weight: bold; }
        
        .stock-tag { font-size: 0.9rem; display: block; margin-bottom: 5px; color: #aaa; }
        .low-stock { color: #ff4444 !important; font-weight: bold; animation: blink 1s infinite; }

        @keyframes blink { 50% { opacity: 0.5; } }

        .btn-add-item {
            background: #2563eb;
            color: white;
            border: 2px solid white;
            padding: 8px 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-add-item:disabled { background: #444; color: #888; border-color: #666; cursor: not-allowed; }
    </style>

    <div class="dashboard-body">
        <div class="pos-wrapper">
            <div class="left-panel">
                <div class="clerk-header">CLERK POS</div>
                
                <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="input-section">
                        <!-- THE TREND FIX: List attribute links to the datalist below[cite: 6] -->
                        <input type="text" 
                               name="customer_name" 
                               id="customer_name_input"
                               list="customer-trends" 
                               placeholder="CUSTOMER NAME" 
                               class="pos-input" 
                               autocomplete="off"
                               required>
                        
                        <datalist id="customer-trends">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->customer_name }}">
                            @endforeach
                        </datalist>

                        <textarea name="customer_address" 
                                  id="customer_address_input" 
                                  placeholder="ADDRESS" 
                                  class="pos-input" 
                                  rows="2"></textarea>

                        <select name="payment_method" class="pos-input font-bold">
                            <option value="Cash">CASH</option>
                            <option value="Card">CARD</option>
                        </select>
                    </div>

                    <div class="cart-area" id="cart-display">
                        <p class="text-gray-400 italic">No items added yet...</p>
                    </div>

                    <div class="total-box">
                        <div class="price-row">
                            <span>TOTAL:</span>
                            <span id="total-text">$0.00</span>
                        </div>
                        
                        <input type="number" id="cash-tendered" placeholder="CASH TENDERED" class="pos-input">
                        <div class="change-display" id="change-text">CHANGE: $0.00</div>
                        
                        <input type="hidden" name="total_amount" id="total_amount_hidden">
                        <input type="hidden" name="items" id="items_hidden">
                        
                        <button type="submit" id="process-btn" class="btn-process" disabled>ADD ITEMS TO START</button>
                    </div>
                </form>
            </div>

            <div class="right-panel">
                @foreach($products as $product)
                    <div class="product-card">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        <div style="flex-grow: 1;">
                            <div class="prod-title">{{ $product->name }}</div>
                            <div class="prod-desc">{{ $product->description }}</div>
                            <span class="stock-tag {{ $product->stock <= 5 ? 'low-stock' : '' }}">
                                STOCK: {{ $product->stock }}
                            </span>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="prod-price">${{ number_format($product->price, 2) }}</span>
                                <button type="button" 
                                        onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock }})"
                                        class="btn-add-item"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $product->stock <= 0 ? 'OUT OF STOCK' : 'ADD' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // 1. DATA FOR TRENDS[cite: 6]
        const customerData = @json($customers->pluck('customer_address', 'customer_name'));

        // 2. AUTO-FILL LOGIC[cite: 6]
        document.getElementById('customer_name_input').addEventListener('input', function(e) {
            const name = e.target.value;
            if (customerData[name]) {
                document.getElementById('customer_address_input').value = customerData[name];
            }
        });

        // --- Existing POS Logic ---
        let cart = [];
        let total = 0;

        function addToCart(id, name, price, maxStock) {
            let item = cart.find(i => i.id === id);
            if(item) {
                if(item.quantity < maxStock) {
                    item.quantity++;
                } else {
                    alert("Cannot add more! Out of stock.");
                    return;
                }
            } else {
                cart.push({ id: id, name: name, price: price, quantity: 1 });
            }
            renderCart();
        }

        function renderCart() {
            const display = document.getElementById('cart-display');
            const btn = document.getElementById('process-btn');
            if(cart.length === 0) {
                display.innerHTML = '<p class="text-gray-400 italic">No items added yet...</p>';
                btn.disabled = true;
                btn.classList.remove('active');
                return;
            }
            total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            display.innerHTML = cart.map(item => `
                <div class="cart-item">
                    <span>${item.name} (x${item.quantity})</span>
                    <span>$${(item.price * item.quantity).toFixed(2)}</span>
                </div>
            `).join('');
            document.getElementById('total-text').innerText = `$${total.toFixed(2)}`;
            document.getElementById('total_amount_hidden').value = total.toFixed(2);
            document.getElementById('items_hidden').value = JSON.stringify(cart);
            btn.disabled = false;
            btn.classList.add('active');
            btn.innerText = "PROCESS TRANSACTION";
            calculateChange();
        }

        function calculateChange() {
            const tendered = parseFloat(document.getElementById('cash-tendered').value) || 0;
            const change = tendered - total;
            const changeBox = document.getElementById('change-text');
            changeBox.innerText = `CHANGE: $${Math.max(0, change).toFixed(2)}`;
            changeBox.style.color = (tendered < total && tendered > 0) ? 'red' : 'black';
        }

        document.getElementById('cash-tendered').addEventListener('input', calculateChange);
    </script>
</x-app-layout>
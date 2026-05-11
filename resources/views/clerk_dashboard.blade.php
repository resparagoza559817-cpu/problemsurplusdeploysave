<x-app-layout>
    <style>
        .pos-body { 
            background: url('/bgbgbg2.png') no-repeat center center fixed; 
            background-size: cover; 
            height: calc(100vh - 65px); 
            display: flex; gap: 10px; padding: 10px; 
            font-family: "Comic Sans MS", cursive !important; 
            overflow: hidden; 
        }
        
        #toast {
            position: fixed; top: 70px; right: 20px;
            background: #2e7d32; color: white; padding: 10px 20px;
            border: 2px solid white; box-shadow: 4px 4px 0px black;
            z-index: 999; font-weight: bold;
        }

        .cart-panel { 
            flex: 0 0 280px; 
            background: white; border: 4px solid black; 
            display: flex; flex-direction: column; 
            box-shadow: 5px 5px 0px #000; height: 100%;
            overflow: hidden;
        }

        .product-panel { 
            flex: 1; 
            background: url('/BlankChalk.png') no-repeat center center; 
            background-size: 100% 100%; 
            padding: 20px 35px; border: 4px solid #3d2b1f; 
            display: flex; flex-direction: column; 
        }

        .scroll-v { overflow-y: auto; flex-grow: 1; }
        
        .prod-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); 
            gap: 12px; padding-bottom: 20px;
        }

        .item-node { 
            background: rgba(255,255,255,0.1); border: 2px dashed white; 
            padding: 10px; text-align: center; color: white; cursor: pointer;
            transition: all 0.2s;
        }
        .item-node:hover { background: rgba(255,255,255,0.2); transform: translateY(-2px); }
        
        /* Product Image Style */
        .prod-img {
            width: 60px; height: 60px; object-fit: contain;
            margin: 0 auto 5px; display: block;
            filter: drop-shadow(2px 2px 0px rgba(0,0,0,0.5));
        }

        .cat-btn { 
            background: #3d2b1f; color: white; padding: 5px 15px; 
            border: 2px solid white; margin-right: 5px; cursor: pointer;
        }
        .cat-btn.active { background: #facc15; color: black; }

        .cart-item { 
            display: flex; justify-content: space-between; align-items: center;
            padding: 8px; border-bottom: 2px solid #eee; font-size: 0.9rem;
        }
        
        .qty-controls { display: flex; align-items: center; gap: 5px; }
        .qty-btn {
            background: black; color: white; width: 24px; height: 24px;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; border: none; cursor: pointer; border-radius: 3px;
        }

        .checkout-box { padding: 15px; border-top: 4px solid black; background: #f9f9f9; }
        
        .input-flat { 
            width: 100%; border: 2px solid black; padding: 8px; 
            margin: 5px 0; font-family: inherit; font-weight: bold;
            background: white !important; color: black !important;
        }

        .btn-pay { 
            width: 100%; background: #ccc; color: #666; border: 3px solid black; 
            padding: 10px; font-weight: bold; cursor: not-allowed; margin-top: 10px;
        }
        .btn-pay.ready { background: #facc15; color: black; cursor: pointer; }
    </style>

    @if(session('success'))
        <div id="toast">{{ session('success') }}</div>
    @endif

    <div class="pos-body">
        <div class="cart-panel">
            <div class="p-3 bg-black text-white font-bold text-center italic">CURRENT TRANSACTION</div>
            
            <div id="cart-list" class="scroll-v p-1">
                <div class="text-center text-gray-400 mt-10">Cart is empty</div>
            </div>

            <div class="checkout-box">
                <div class="flex justify-between font-bold text-xl mb-2">
                    <span>TOTAL:</span>
                    <span id="cart-total">₱0.00</span>
                </div>

                <label class="text-xs font-bold">PAYMENT METHOD</label>
                <select id="pay-method" class="input-flat">
                    <option value="Cash">Cash</option>
                    <option value="Card">G-Cash / Card</option>
                </select>

                <label class="text-xs font-bold">CASH TENDERED</label>
                <input type="number" id="cash-in" class="input-flat" placeholder="0.00" step="0.01">

                <div id="change-display" class="text-sm font-bold text-right text-blue-600 mt-1">CHANGE: ₱0.00</div>

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total_amount" id="total-val">
                    <input type="hidden" name="payment_method" id="method-val">
                    <input type="hidden" name="items" id="items-val">
                    <input type="hidden" name="cash_tendered" id="cash-val">
                    <button type="submit" id="process-btn" class="btn-pay" disabled>SELECT ITEMS</button>
                </form>
            </div>
        </div>

        <div class="product-panel">
            <div class="flex justify-between items-center mb-4 border-b-2 border-white/20 pb-2">
                <div class="flex">
                    <button class="cat-btn active" onclick="filterCat('all')">ALL</button>
                    @foreach($categories as $cat)
                        <button class="cat-btn" onclick="filterCat('{{ $cat->id }}')">{{ strtoupper($cat->name) }}</button>
                    @endforeach
                </div>
            </div>

            <div class="scroll-v">
                <div class="prod-grid">
                    @foreach($products as $prod)
                        <div class="item-node" 
                             data-cat="{{ $prod->category_id }}"
                             onclick="addToCart({{ $prod->id }}, '{{ $prod->name }}', {{ $prod->price }})">
                            
                            @if($prod->image)
                                <img src="{{ asset('storage/' . $prod->image) }}" class="prod-img">
                            @endif

                            <div class="font-bold text-sm leading-tight mb-1">{{ $prod->name }}</div>
                            <div class="text-yellow-400 font-bold">₱{{ $prod->price }}</div>
                            <div class="text-[10px] opacity-60">STOCK: {{ $prod->stock }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let total = 0;

        function addToCart(id, name, price) {
            const existing = cart.find(i => i.id === id);
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({ id, name, price, quantity: 1 });
            }
            renderCart();
        }

        function updateQty(id, amount) {
            const item = cart.find(i => i.id === id);
            if (!item) return;

            item.quantity += amount;
            if (item.quantity <= 0) {
                cart = cart.filter(i => i.id !== id);
            }
            renderCart();
        }

        function renderCart() {
            const list = document.getElementById('cart-list');
            list.innerHTML = '';
            total = 0;

            if (cart.length === 0) {
                list.innerHTML = '<div class="text-center text-gray-400 mt-10">Cart is empty</div>';
            }

            cart.forEach(item => {
                const subtotal = item.price * item.quantity;
                total += subtotal;
                list.innerHTML += `
                    <div class="cart-item">
                        <div style="flex:1">
                            <div class="font-bold">${item.name}</div>
                            <div class="text-xs text-gray-500">₱${item.price} x ${item.quantity}</div>
                        </div>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="updateQty(${item.id}, -1)">-</button>
                            <button class="qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                        </div>
                    </div>`;
            });

            document.getElementById('cart-total').innerText = `₱${total.toFixed(2)}`;
            document.getElementById('total-val').value = total;
            document.getElementById('items-val').value = JSON.stringify(cart);
            validate();
        }

        function validate() {
            const btn = document.getElementById('process-btn');
            const cashInput = document.getElementById('cash-in');
            const method = document.getElementById('pay-method').value;
            const cash = parseFloat(cashInput.value) || 0;
            const change = cash - total;

            document.getElementById('method-val').value = method;
            document.getElementById('cash-val').value = cash;
            document.getElementById('change-display').innerText = `CHANGE: ₱${Math.max(0, change).toFixed(2)}`;

            if (cart.length > 0) {
                if (method === 'Card') {
                    // Card is always ready
                    btn.disabled = false;
                    btn.classList.add('ready');
                    btn.innerText = "CONFIRM TRANSACTION";
                } else {
                    // Cash needs enough money
                    if (cash >= total) {
                        btn.disabled = false;
                        btn.classList.add('ready');
                        btn.innerText = "CONFIRM TRANSACTION";
                    } else {
                        btn.disabled = true;
                        btn.classList.remove('ready');
                        btn.innerText = "INSUFFICIENT CASH";
                    }
                }
            } else {
                btn.disabled = true;
                btn.classList.remove('ready');
                btn.innerText = "SELECT ITEMS";
            }
        }

        function filterCat(id) {
            document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
            document.querySelectorAll('.item-node').forEach(c => {
                c.style.display = (id === 'all' || c.dataset.cat === id) ? 'block' : 'none';
            });
        }

        // Listeners
        document.getElementById('cash-in').addEventListener('input', validate);
        document.getElementById('pay-method').addEventListener('change', () => {
            const cashInput = document.getElementById('cash-in');
            if(document.getElementById('pay-method').value === 'Card') {
                cashInput.value = ''; 
                cashInput.style.opacity = '0.5';
            } else {
                cashInput.style.opacity = '1';
            }
            validate();
        });

        setTimeout(() => { 
            const toast = document.getElementById('toast');
            if(toast) toast.style.display = 'none'; 
        }, 3000);
    </script>
</x-app-layout>
<x-app-layout>
    <style>
        .stats-body {
            background: url('/bgbgbg2.png') no-repeat center center fixed;
            background-size: cover;
            height: calc(100vh - 65px);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: "Comic Sans MS", cursive !important;
            padding: 5px;
        }
        .chalk-board {
            width: 98%;
            max-width: 1050px;
            height: 92%; 
            background: url('/BlankChalk.png') no-repeat center center;
            background-size: 100% 100%;
            padding: 30px 60px; /* Reduced top/bottom padding */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 5px;
        }
        .stat-box {
            background: rgba(255,255,255,0.05);
            border: 2px dashed rgba(255,255,255,0.2);
            padding: 10px;
            text-align: center;
        }
        .stat-value { font-size: 1.4rem; font-weight: bold; color: #facc15; }
        .stat-label { font-size: 0.65rem; text-transform: uppercase; opacity: 0.8; margin-bottom: 2px; }
        .comparison { font-size: 0.6rem; color: #bbb; font-style: italic; display: block; }
        
        .inventory-section {
            margin-top: 15px; /* Tightened space between sections */
            border-top: 1px dashed rgba(255,255,255,0.2);
            padding-top: 10px;
        }
        
        .low-stock { color: #ff4444 !important; border-color: #ff4444 !important; }
        .footer-text { text-align: center; opacity: 0.4; font-size: 0.7rem; padding-bottom: 5px; }
    </style>

    <div class="stats-body">
        <div class="chalk-board">
            <div>
                <h1 class="text-2xl font-bold border-b-2 border-white/20 pb-1 uppercase italic mb-3">
                    Store Performance
                </h1>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-label">Sales Today</div>
                        <div class="stat-value">₱{{ number_format($revenueToday, 2) }}</div>
                        <span class="comparison">Yesterday: ₱{{ number_format($revenueYesterday, 2) }}</span>
                    </div>

                    <div class="stat-box">
                        <div class="stat-label">This Week</div>
                        <div class="stat-value">₱{{ number_format($revenueThisWeek, 2) }}</div>
                        <span class="comparison">Last: ₱{{ number_format($revenueLastWeek, 2) }}</span>
                    </div>

                    <div class="stat-box">
                        <div class="stat-label">Lifetime</div>
                        <div class="stat-value">₱{{ number_format($totalMoney, 2) }}</div>
                        <span class="comparison">Total Earnings</span>
                    </div>

                    <div class="stat-box">
                        <div class="stat-label">Transactions</div>
                        <div class="stat-value">{{ $totalSalesCount }}</div>
                        <span class="comparison">Total Orders</span>
                    </div>
                </div>

                <div class="inventory-section">
                    <h2 class="text-lg font-bold mb-2 opacity-50 uppercase tracking-widest text-center">Inventory Status</h2>
                    <div class="stats-grid" style="grid-template-columns: repeat(2, 1fr); max-width: 450px; margin: 0 auto;">
                        <div class="stat-box">
                            <div class="stat-label">Total Products</div>
                            <div class="stat-value">{{ $totalProducts }}</div>
                        </div>
                        <div class="stat-box {{ $lowStockCount > 0 ? 'low-stock' : '' }}">
                            <div class="stat-label">Low Stock Alert</div>
                            <div class="stat-value">{{ $lowStockCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-text">
                CHALKBOARD UPDATED: {{ now()->format('h:i A') }}
            </div>
        </div>
    </div>
</x-app-layout>
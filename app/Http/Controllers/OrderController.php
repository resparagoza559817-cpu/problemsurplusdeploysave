<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * View History Page[cite: 5]
     */
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Combined Dashboard Logic
     * Fetches Products, Categories, and Customer Trends[cite: 4, 6]
     */
    public function dashboard()
    {
        $products = Product::all();
        $categories = Category::all();
        
        // Fetch unique customers for the autocompletion "Trend"[cite: 4]
        $customers = Order::select('customer_name', 'customer_address')
            ->whereNotNull('customer_name')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('customer_name');

        // Logic moved from routes/web.php to here[cite: 4, 10]
        if (Auth::user()->role === 'user') {
            return view('clerk_dashboard', compact('products', 'categories', 'customers'));
        }
        
        return view('dashboard', compact('products', 'categories', 'customers'));
    }

    /**
     * Process POS Transaction[cite: 5, 8]
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'items' => 'required|json',
        ]);

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->customer_address = $request->customer_address;
        $order->total_amount = $request->total_amount;
        $order->payment_method = $request->payment_method;
        $order->user_id = Auth::id();
        $order->save();

        // Stock Deduction[cite: 1]
        $items = json_decode($request->items, true);
        foreach ($items as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        return redirect()->route('dashboard')->with('success', 'TRANSACTION SAVED!');
    }

    /**
     * Admin Delete Order[cite: 5]
     */
    public function destroy(Order $order)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        $order->delete();
        return redirect()->back()->with('success', 'Record deleted.');
    }
}
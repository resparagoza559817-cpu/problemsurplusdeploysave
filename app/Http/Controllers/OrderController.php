<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('orders.index', compact('orders'));
    }

    public function dashboard()
    {
        $totalMoney = Order::sum('total_amount');
        $revenueToday = Order::whereDate('created_at', Carbon::today())->sum('total_amount');
        $revenueYesterday = Order::whereDate('created_at', Carbon::yesterday())->sum('total_amount');
        $revenueThisWeek = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_amount');
        $revenueLastWeek = Order::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->sum('total_amount');
        
        $totalSalesCount = Order::count(); 
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        return view('dashboard', compact('totalMoney', 'revenueToday', 'revenueYesterday', 'revenueThisWeek', 'revenueLastWeek', 'totalSalesCount', 'totalProducts', 'lowStockCount'));
    }

    public function pos()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('clerk_dashboard', compact('products', 'categories'));
    }

    public function store(Request $request) 
    { 
        $request->validate([ 
            'total_amount' => 'required|numeric', 
            'payment_method' => 'required', 
            'items' => 'required|json' 
        ]); 

        $cartItems = json_decode($request->items, true); 

        foreach ($cartItems as $item) { 
            $product = Product::find($item['id']); 
            if (!$product || $product->stock < $item['quantity']) { 
                return redirect()->back()->with('error', "STOCK DEPLETED: {$item['name']} only has {$product->stock} left!"); 
            } 
        } 

        $order = new Order(); 
        $order->customer_name = "Walk-in"; 
        $order->total_amount = $request->total_amount; 
        $order->payment_method = $request->payment_method; 
        $order->cash_tendered = $request->cash_tendered ?? 0; 
        $order->change_amount = ($request->cash_tendered ?? 0) - $request->total_amount; 
        $order->items_json = $request->items; 
        $order->user_id = Auth::id(); 
        $order->save(); 

        foreach ($cartItems as $item) { 
            Product::find($item['id'])->decrement('stock', $item['quantity']); 
        } 

        return redirect()->back()->with('success', 'SALE RECORDED!'); 
    }

    public function destroy(Order $order)
    {
        // FINAL SECURITY FIX: Only admin can delete
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();
        return redirect()->back()->with('success', 'Order Deleted!');
    }
}
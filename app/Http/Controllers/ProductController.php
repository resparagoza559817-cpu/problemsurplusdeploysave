<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // Add this!

class ProductController extends Controller
{
    public function index(Request $request)
{
    // Start the query with the category relationship
    $query = Product::with('category');

    // 1. Filter by Category if selected
    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }

    // 2. Sort Logic
    $sort = $request->get('sort', 'name'); // Default sort by name
    $direction = $request->get('direction', 'asc');

    // Apply sorting
    $query->orderBy($sort, $direction);

    $products = $query->get();
    $categories = Category::all(); // Need this for the dropdown

    return view('dashboard', compact('products', 'categories'));
}

   public function create()
{
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('dashboard')->with('error', 'Unauthorized.');
    }
    $categories = \App\Models\Category::all(); // Get them from DB
    return view('products.create', compact('categories'));
}

   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            // Stores in storage/app/public/products
            $path = $request->file('image')->store('products', 'public');
            $product->image_path = $path;
        }

        $product->save();
        return redirect()->route('dashboard');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            // Delete old image if it exists[cite: 7]
            if ($product->image_path) {
                \Storage::disk('public')->delete($product->image_path);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image_path = $path;
        }

        $product->save();
        return redirect()->route('dashboard');
    }
    public function edit(Product $product)
    {
        // Pass categories so you can change them in the edit screen
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        Product::findOrFail($id)->delete();
        return redirect()->route('dashboard');
    }
}
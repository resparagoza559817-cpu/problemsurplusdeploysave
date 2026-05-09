<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show the list of categories
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Save a new category
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories']);
        Category::create($request->all());
        return back()->with('success', 'Category added!');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        // Don't let them delete "General"
        if($category->name === 'General') {
            return back()->with('error', 'Cannot delete default category.');
        }
        
        $category->delete();
        return back()->with('success', 'Category deleted!');
    }
}
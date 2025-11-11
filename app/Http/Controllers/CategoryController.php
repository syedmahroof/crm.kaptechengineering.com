<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view categories'), 403, 'Unauthorized action.');
        
        $categories = Category::withCount('products')->paginate(15);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create categories'), 403, 'Unauthorized action.');
        
        return view('categories.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create categories'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load('products');

        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        abort_unless(auth()->user()->can('edit categories'), 403, 'Unauthorized action.');
        
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_unless(auth()->user()->can('edit categories'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        abort_unless(auth()->user()->can('delete categories'), 403, 'Unauthorized action.');
        
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}

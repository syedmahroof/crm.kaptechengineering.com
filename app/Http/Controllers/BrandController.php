<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        abort_unless(auth()->user()->can('view brands'), 403, 'Unauthorized action.');
        
        $brands = Brand::withCount('products')->paginate(15);

        return view('brands.index', compact('brands'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create brands'), 403, 'Unauthorized action.');
        
        return view('brands.create');
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create brands'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Brand::create($validated);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        $brand->load('products');

        return view('brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        abort_unless(auth()->user()->can('edit brands'), 403, 'Unauthorized action.');
        
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        abort_unless(auth()->user()->can('edit brands'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $brand->update($validated);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        abort_unless(auth()->user()->can('delete brands'), 403, 'Unauthorized action.');
        
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}

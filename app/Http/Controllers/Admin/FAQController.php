<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = FAQ::query();

        // Apply filters
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortDirection = $request->get('sort_direction', 'asc');
        $query->orderBy($sortBy, $sortDirection);

        $faqs = $query->paginate(12);

        $categories = FAQ::distinct()->pluck('category')->filter()->sort()->values();

        return view('admin.faqs.index', [
            'faqs' => $faqs,
            'categories' => $categories,
            'filters' => $request->only(['status', 'category', 'search', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'General',
            'Booking',
            'Payment',
            'Travel',
            'Cancellation',
            'Visa',
            'Insurance',
            'Support',
        ];

        return view('admin.faqs.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['_token', '_method']);

        // Convert boolean strings to actual booleans
        $data['is_active'] = filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN);

        FAQ::create($data);

        return redirect()->route('admin.faqs.index')
                        ->with('success', 'FAQ created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $faq)
    {
        return view('admin.faqs.show', [
            'faq' => $faq,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq)
    {
        $categories = [
            'General',
            'Booking',
            'Payment',
            'Travel',
            'Cancellation',
            'Visa',
            'Insurance',
            'Support',
        ];

        return view('admin.faqs.edit', [
            'faq' => $faq,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQ $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'required|string|max:255',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['_token', '_method']);

        // Convert boolean strings to actual booleans
        $data['is_active'] = filter_var($data['is_active'] ?? true, FILTER_VALIDATE_BOOLEAN);

        $faq->update($data);

        return redirect()->route('admin.faqs.index')
                        ->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
                        ->with('success', 'FAQ deleted successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(FAQ $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $faq->is_active,
        ]);
    }
}

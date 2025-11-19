<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Quotation::with(['customer', 'lead', 'project', 'user'])->orderBy('quotation_date', 'desc');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%");
                  })
                  ->orWhereHas('lead', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $quotations = $query->paginate(15);
        $projects = \App\Models\Project::orderBy('name')->get();

        return view('admin.quotations.index', [
            'quotations' => $quotations,
            'projects' => $projects,
            'filters' => $request->only(['search', 'status', 'project_id']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $products = Product::active()->orderBy('name')->get();
        $customers = \App\Models\Customer::orderBy('first_name')->orderBy('last_name')->get();
        $leads = \App\Models\Lead::orderBy('name')->get();
        $projects = \App\Models\Project::orderBy('name')->get();

        $quotationNumber = Quotation::generateQuotationNumber();

        return view('admin.quotations.create', [
            'products' => $products,
            'customers' => $customers,
            'leads' => $leads,
            'projects' => $projects,
            'quotationNumber' => $quotationNumber,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quotation_number' => 'required|string|max:255|unique:quotations,quotation_number',
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date|after:quotation_date',
            'status' => 'required|in:draft,sent,accepted,rejected,expired,converted',
            'customer_id' => 'nullable|exists:customers,id',
            'lead_id' => 'nullable|exists:leads,id',
            'project_id' => 'nullable|exists:projects,id',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'currency' => 'nullable|string|max:3',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            $validated['user_id'] = auth()->id();
            $items = $validated['items'];
            unset($validated['items']);

            // Calculate totals
            $subtotal = 0;
            foreach ($items as $item) {
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemSubtotal * ($item['discount_rate'] ?? 0) / 100;
                $itemAfterDiscount = $itemSubtotal - $itemDiscount;
                $itemTax = $itemAfterDiscount * ($item['tax_rate'] ?? 0) / 100;
                $subtotal += $itemAfterDiscount + $itemTax;
            }

            $validated['subtotal'] = $subtotal;
            $validated['discount_amount'] = $subtotal * ($validated['discount_rate'] ?? 0) / 100;
            $validated['tax_amount'] = ($subtotal - $validated['discount_amount']) * ($validated['tax_rate'] ?? 0) / 100;
            $validated['total_amount'] = $subtotal - $validated['discount_amount'] + $validated['tax_amount'];
            $validated['currency'] = $validated['currency'] ?? 'USD';

            $quotation = Quotation::create($validated);

            // Create quotation items
            foreach ($items as $index => $item) {
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemSubtotal * ($item['discount_rate'] ?? 0) / 100;
                $itemAfterDiscount = $itemSubtotal - $itemDiscount;
                $itemTax = $itemAfterDiscount * ($item['tax_rate'] ?? 0) / 100;
                $itemTotal = $itemAfterDiscount + $itemTax;

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item['product_id'] ?? null,
                    'item_name' => $item['item_name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? null,
                    'unit_price' => $item['unit_price'],
                    'discount_rate' => $item['discount_rate'] ?? 0,
                    'discount_amount' => $itemDiscount,
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $itemTax,
                    'total' => $itemTotal,
                    'sort_order' => $index,
                ]);
            }

            DB::commit();

            return redirect()->route('quotations.index')
                            ->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create quotation: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load(['customer', 'lead', 'project', 'user', 'items.product']);

        return view('admin.quotations.show', [
            'quotation' => $quotation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quotation $quotation)
    {
        $quotation->load('items');
        $products = Product::active()->orderBy('name')->get();
        $customers = \App\Models\Customer::orderBy('first_name')->orderBy('last_name')->get();
        $leads = \App\Models\Lead::orderBy('name')->get();
        $projects = \App\Models\Project::orderBy('name')->get();

        return view('admin.quotations.edit', [
            'quotation' => $quotation,
            'products' => $products,
            'customers' => $customers,
            'leads' => $leads,
            'projects' => $projects,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'quotation_number' => 'required|string|max:255|unique:quotations,quotation_number,' . $quotation->id,
            'quotation_date' => 'required|date',
            'valid_until' => 'nullable|date|after:quotation_date',
            'status' => 'required|in:draft,sent,accepted,rejected,expired,converted',
            'customer_id' => 'nullable|exists:customers,id',
            'lead_id' => 'nullable|exists:leads,id',
            'project_id' => 'nullable|exists:projects,id',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
            'currency' => 'nullable|string|max:3',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            $items = $validated['items'];
            unset($validated['items']);

            // Calculate totals
            $subtotal = 0;
            foreach ($items as $item) {
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemSubtotal * ($item['discount_rate'] ?? 0) / 100;
                $itemAfterDiscount = $itemSubtotal - $itemDiscount;
                $itemTax = $itemAfterDiscount * ($item['tax_rate'] ?? 0) / 100;
                $subtotal += $itemAfterDiscount + $itemTax;
            }

            $validated['subtotal'] = $subtotal;
            $validated['discount_amount'] = $subtotal * ($validated['discount_rate'] ?? 0) / 100;
            $validated['tax_amount'] = ($subtotal - $validated['discount_amount']) * ($validated['tax_rate'] ?? 0) / 100;
            $validated['total_amount'] = $subtotal - $validated['discount_amount'] + $validated['tax_amount'];
            $validated['currency'] = $validated['currency'] ?? 'USD';

            $quotation->update($validated);

            // Delete existing items and create new ones
            $quotation->items()->delete();

            foreach ($items as $index => $item) {
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemDiscount = $itemSubtotal * ($item['discount_rate'] ?? 0) / 100;
                $itemAfterDiscount = $itemSubtotal - $itemDiscount;
                $itemTax = $itemAfterDiscount * ($item['tax_rate'] ?? 0) / 100;
                $itemTotal = $itemAfterDiscount + $itemTax;

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item['product_id'] ?? null,
                    'item_name' => $item['item_name'],
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? null,
                    'unit_price' => $item['unit_price'],
                    'discount_rate' => $item['discount_rate'] ?? 0,
                    'discount_amount' => $itemDiscount,
                    'tax_rate' => $item['tax_rate'] ?? 0,
                    'tax_amount' => $itemTax,
                    'total' => $itemTotal,
                    'sort_order' => $index,
                ]);
            }

            DB::commit();

            return redirect()->route('quotations.index')
                            ->with('success', 'Quotation updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update quotation: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()->route('quotations.index')
                        ->with('success', 'Quotation deleted successfully.');
    }
}

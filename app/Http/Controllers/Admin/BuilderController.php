<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Builder;
use App\Models\Country;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$this->authorize('viewAny', Builder::class);
        
        $builders = Builder::with(['country', 'state', 'district'])
            ->latest()
            ->paginate(15);

        return view('admin.builders.index', compact('builders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$this->authorize('create', Builder::class);
        
        $countries = Country::orderBy('name')->get();
        $branches = \App\Models\Branch::active()->get();
        return view('admin.builders.create', compact('countries', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Builder::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:builders,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => [
                'required',
                Rule::exists('states', 'id')->where(function ($query) use ($request) {
                    return $query->where('country_id', $request->country_id);
                })
            ],
            'district_id' => [
                'required',
                Rule::exists('districts', 'id')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id);
                })
            ],
            'pincode' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:50|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            'status' => 'boolean',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $builder = Builder::create($validated);

        return redirect()->route('builders.show', $builder)
            ->with('success', 'Builder created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Builder $builder)
    {
        $this->authorize('view', $builder);
        
        $builder->load(['country', 'state', 'district', 'projects']);
        return view('admin.builders.show', compact('builder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Builder $builder)
    {
        $this->authorize('update', $builder);
        
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $builder->country_id)->orderBy('name')->get();
        $districts = District::where('state_id', $builder->state_id)->orderBy('name')->get();
        $branches = \App\Models\Branch::active()->get();

        return view('admin.builders.edit', compact('builder', 'countries', 'states', 'districts', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Builder $builder)
    {
        $this->authorize('update', $builder);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('builders')->ignore($builder->id)
            ],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'state_id' => [
                'required',
                Rule::exists('states', 'id')->where(function ($query) use ($request) {
                    return $query->where('country_id', $request->country_id);
                })
            ],
            'district_id' => [
                'required',
                Rule::exists('districts', 'id')->where(function ($query) use ($request) {
                    return $query->where('state_id', $request->state_id);
                })
            ],
            'pincode' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'gst_number' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
                Rule::unique('builders')->ignore($builder->id)
            ],
            'status' => 'boolean',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $builder->update($validated);

        return redirect()->route('builders.show', $builder)
            ->with('success', 'Builder updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Builder $builder)
    {
        $this->authorize('delete', $builder);
        
        if ($builder->projects()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete builder with associated projects.');
        }

        $builder->delete();

        return redirect()->route('builders.index')
            ->with('success', 'Builder deleted successfully');
    }

    /**
     * Toggle builder status
     */
    public function toggleStatus(Builder $builder)
    {
        $this->authorize('update', $builder);
        
        $builder->update([
            'status' => !$builder->status
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Get states for a country
     */
    public function getStates(Country $country)
    {
        return response()->json($country->states()->orderBy('name')->get());
    }

    /**
     * Get districts for a state
     */
    public function getDistricts(State $state)
    {
        return response()->json($state->districts()->orderBy('name')->get());
    }
}
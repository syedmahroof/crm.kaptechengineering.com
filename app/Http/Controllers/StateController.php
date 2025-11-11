<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(auth()->user()->can('view states'), 403, 'Unauthorized action.');
        
        $query = State::with(['country'])->withCount('cities');

        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        $states = $query->orderBy('name')->paginate(15);
        $countries = Country::orderBy('name')->get();

        return view('states.index', compact('states', 'countries'));
    }

    public function create()
    {
        abort_unless(auth()->user()->can('create states'), 403, 'Unauthorized action.');
        
        $countries = Country::orderBy('name')->get();

        return view('states.create', compact('countries'));
    }

    public function store(Request $request)
    {
        abort_unless(auth()->user()->can('create states'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        State::create($validated);

        return redirect()->route('states.index')->with('success', 'State created successfully.');
    }

    public function show(State $state)
    {
        $state->load(['country', 'cities']);

        return view('states.show', compact('state'));
    }

    public function edit(State $state)
    {
        abort_unless(auth()->user()->can('edit states'), 403, 'Unauthorized action.');
        
        $countries = Country::orderBy('name')->get();

        return view('states.edit', compact('state', 'countries'));
    }

    public function update(Request $request, State $state)
    {
        abort_unless(auth()->user()->can('edit states'), 403, 'Unauthorized action.');
        
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10',
            'is_active' => 'boolean',
        ]);

        $state->update($validated);

        return redirect()->route('states.index')->with('success', 'State updated successfully.');
    }

    public function destroy(State $state)
    {
        abort_unless(auth()->user()->can('delete states'), 403, 'Unauthorized action.');
        
        $state->delete();

        return redirect()->route('states.index')->with('success', 'State deleted successfully.');
    }
}

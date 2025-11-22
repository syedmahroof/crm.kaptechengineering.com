<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Get all states/provinces
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = State::with('country')->orderBy('name');

        // Filter by country if provided
        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Search by name if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter active states only if requested
        if ($request->has('active') && $request->active == 'true') {
            $query->where('is_active', true);
        }

        $states = $query->get();

        return response()->json($states);
    }
}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Get all districts/cities
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = District::with(['state', 'country'])->orderBy('name');

        // Filter by country if provided
        if ($request->has('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        // Filter by state if provided
        if ($request->has('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        // Search by name if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter active districts only if requested
        if ($request->has('active') && $request->active == 'true') {
            $query->where('is_active', true);
        }

        $districts = $query->get();

        return response()->json($districts);
    }
}

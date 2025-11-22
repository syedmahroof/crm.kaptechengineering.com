<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Get all countries
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Country::orderBy('name');

        // Filter active countries only if requested
        if ($request->has('active') && $request->active == 'true') {
            $query->where('is_active', true);
        }

        // Search by name if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $countries = $query->get();

        return response()->json($countries);
    }
}


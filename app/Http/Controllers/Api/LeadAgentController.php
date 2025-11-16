<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeadAgent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LeadAgentController extends Controller
{
    /**
     * Get all active lead agents
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $agents = LeadAgent::with('user')
                ->where('status', 'active')
                ->get()
                ->map(function ($agent) {
                    return [
                        'id' => $agent->id,
                        'name' => $agent->user ? $agent->user->name : 'Unknown',
                        'email' => $agent->user ? $agent->user->email : '',
                        'phone' => $agent->user ? $agent->user->phone : '',
                        'status' => $agent->status,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $agents
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch lead agents',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

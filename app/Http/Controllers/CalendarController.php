<?php

namespace App\Http\Controllers;

use App\Models\Followup;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function events()
    {
        $followups = Followup::with(['lead', 'user'])->get();

        $events = $followups->map(function ($followup) {
            return [
                'id' => $followup->id,
                'title' => $followup->lead->name.' - '.$followup->status,
                'start' => $followup->followup_date->toIso8601String(),
                'backgroundColor' => $this->getStatusColor($followup->status),
                'borderColor' => $this->getStatusColor($followup->status),
                'extendedProps' => [
                    'lead_id' => $followup->lead_id,
                    'remarks' => $followup->remarks,
                    'status' => $followup->status,
                ],
            ];
        });

        return response()->json($events);
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'pending' => '#ffc107',
            'completed' => '#28a745',
            'cancelled' => '#dc3545',
            default => '#6c757d',
        };
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FlightTicket;
use App\Models\Lead;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FlightTicketsController extends Controller
{
    public function create(Request $request)
    {
        $leadId = $request->get('lead_id');
        $lead = null;
        
        if ($leadId) {
            $lead = Lead::with(['business_type'])->find($leadId);
        }

        return view('admin.flight-tickets.create', [
            'lead' => $lead,
            'statuses' => FlightTicket::statuses(),
            'classTypes' => FlightTicket::classTypes(),
            'budgetRanges' => FlightTicket::budgetRanges(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'departure_airport' => 'required|string|max:255',
            'arrival_airport' => 'required|string|max:255',
            'departure_date' => 'required|date|after:today',
            'return_date' => 'nullable|date|after:departure_date',
            'passenger_count' => 'required|integer|min:1|max:20',
            'class_type' => 'required|in:economy,premium_economy,business,first',
            'airline_preference' => 'nullable|string|max:255',
            'budget_range' => 'required|in:budget,mid_range,premium,luxury',
            'special_requests' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:10240', // 10MB max per file
            'attachment_descriptions' => 'nullable|array',
            'attachment_descriptions.*' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        $flightTicket = FlightTicket::create($validated);

        // Handle multiple file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $path = $file->store('flight-tickets/files', 'public');
                $description = $request->input("attachment_descriptions.{$index}", null);

                $flightTicket->files()->create([
                    'name' => $file->getClientOriginalName(),
                    'description' => $description,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'user_id' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('flight-tickets.show', $flightTicket)
            ->with('success', 'Flight ticket request created successfully.');
    }

    public function show(FlightTicket $flightTicket)
    {
        $flightTicket->load(['lead', 'creator', 'updater', 'files.user']);

        return view('admin.flight-tickets.show', [
            'flightTicket' => $flightTicket,
            'statuses' => FlightTicket::statuses(),
            'classTypes' => FlightTicket::classTypes(),
            'budgetRanges' => FlightTicket::budgetRanges(),
        ]);
    }

    public function edit(FlightTicket $flightTicket)
    {
        $flightTicket->load(['lead']);

        return view('admin.flight-tickets.edit', [
            'flightTicket' => $flightTicket,
            'statuses' => FlightTicket::statuses(),
            'classTypes' => FlightTicket::classTypes(),
            'budgetRanges' => FlightTicket::budgetRanges(),
        ]);
    }

    public function update(Request $request, FlightTicket $flightTicket)
    {
        $validated = $request->validate([
            'departure_airport' => 'required|string|max:255',
            'arrival_airport' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date|after:departure_date',
            'passenger_count' => 'required|integer|min:1|max:20',
            'class_type' => 'required|in:economy,premium_economy,business,first',
            'airline_preference' => 'nullable|string|max:255',
            'budget_range' => 'required|in:budget,mid_range,premium,luxury',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,quoted,booked,confirmed,cancelled',
            'booking_reference' => 'nullable|string|max:255',
            'total_cost' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|size:3',
        ]);

        $validated['updated_by'] = auth()->id();

        $flightTicket->update($validated);

        return redirect()->route('flight-tickets.show', $flightTicket)
            ->with('success', 'Flight ticket updated successfully.');
    }

    public function destroy(FlightTicket $flightTicket)
    {
        // Delete associated files
        foreach ($flightTicket->files as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        $flightTicket->delete();

        return redirect()->route('leads.show', $flightTicket->lead_id)
            ->with('success', 'Flight ticket deleted successfully.');
    }

    public function storeFiles(Request $request, FlightTicket $flightTicket)
    {
        $request->validate([
            'attachments' => 'required|array|min:1',
            'attachments.*' => 'file|max:10240', // 10MB max per file
            'attachment_descriptions' => 'nullable|array',
            'attachment_descriptions.*' => 'nullable|string|max:255',
        ]);

        $uploadedFiles = [];

        foreach ($request->file('attachments') as $index => $file) {
            $path = $file->store('flight-tickets/files', 'public');
            $description = $request->input("attachment_descriptions.{$index}", null);

            $uploadedFile = $flightTicket->files()->create([
                'name' => $file->getClientOriginalName(),
                'description' => $description,
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'user_id' => Auth::id(),
            ]);

            $uploadedFiles[] = $uploadedFile->load('user');
        }

        return response()->json([
            'success' => true,
            'files' => $uploadedFiles,
            'message' => count($uploadedFiles) . ' file(s) uploaded successfully.',
        ]);
    }

    public function deleteFile(FlightTicket $flightTicket, File $file)
    {
        // Verify the file belongs to this flight ticket
        if ($file->fileable_type !== FlightTicket::class || $file->fileable_id !== $flightTicket->id) {
            return response()->json([
                'success' => false,
                'message' => 'File not found.',
            ], 404);
        }

        Storage::disk('public')->delete($file->path);
        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File deleted successfully.',
        ]);
    }

    public function downloadFile(FlightTicket $flightTicket, File $file)
    {
        // Verify the file belongs to this flight ticket
        if ($file->fileable_type !== FlightTicket::class || $file->fileable_id !== $flightTicket->id) {
            abort(404);
        }

        if (!Storage::disk('public')->exists($file->path)) {
            abort(404);
        }

        return Storage::disk('public')->download($file->path, $file->name);
    }
}

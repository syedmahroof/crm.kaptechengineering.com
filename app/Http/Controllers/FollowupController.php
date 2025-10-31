<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use App\Models\Lead;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    public function index()
    {
        $followups = Followup::with(['lead', 'user'])->latest('followup_date')->paginate(15);

        return view('followups.index', compact('followups'));
    }

    public function create()
    {
        $leads = Lead::all();

        return view('followups.create', compact('leads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'followup_date' => 'required|date',
            'type' => 'required|in:email,call,sms,meeting,payment_reminder,other',
            'remarks' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $validated['user_id'] = auth()->id();

        Followup::create($validated);

        return redirect()->back()->with('success', 'Follow-up scheduled successfully.');
    }

    public function show(Followup $followup)
    {
        $followup->load(['lead', 'user']);

        return view('followups.show', compact('followup'));
    }

    public function edit(Followup $followup)
    {
        $leads = Lead::all();

        return view('followups.edit', compact('followup', 'leads'));
    }

    public function update(Request $request, Followup $followup)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'followup_date' => 'required|date',
            'type' => 'required|in:email,call,sms,meeting,payment_reminder,other',
            'remarks' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $followup->update($validated);

        return redirect()->back()->with('success', 'Follow-up updated successfully.');
    }

    public function destroy(Followup $followup)
    {
        $followup->delete();

        return redirect()->back()->with('success', 'Follow-up deleted successfully.');
    }
}

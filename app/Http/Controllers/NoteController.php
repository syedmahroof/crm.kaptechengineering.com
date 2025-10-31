<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with(['lead', 'user'])->latest()->paginate(15);

        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        $leads = Lead::all();

        return view('notes.create', compact('leads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'note' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        Note::create($validated);

        return redirect()->back()->with('success', 'Note added successfully.');
    }

    public function show(Note $note)
    {
        $note->load(['lead', 'user']);

        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $leads = Lead::all();

        return view('notes.edit', compact('note', 'leads'));
    }

    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'note' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->back()->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully.');
    }
}

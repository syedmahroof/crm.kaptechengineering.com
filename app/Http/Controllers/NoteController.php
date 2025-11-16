<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get standalone notes (where noteable_id is null)
        $query = Note::with('user')
            ->where('user_id', auth()->id())
            ->whereNull('noteable_id');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('pinned')) {
            $query->where('is_pinned', $request->pinned == '1');
        }

        // Sort: pinned first, then by created_at
        $query->orderBy('is_pinned', 'desc')
              ->orderBy('created_at', 'desc');

        $notes = $query->paginate(20);

        $categories = Note::getCategories();

        return view('admin.notes.index', [
            'notes' => $notes,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'pinned']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'is_pinned' => 'boolean',
        ]);

        $validated['user_id'] = auth()->id();
        // Ensure noteable fields are null for standalone notes
        $validated['noteable_id'] = null;
        $validated['noteable_type'] = null;

        $note = Note::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note created successfully.',
                'note' => $note->load('user'),
            ]);
        }

        return redirect()->route('notes.index')
                        ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        // Ensure user can only view their own notes and it's a standalone note
        if ($note->user_id !== auth()->id() || $note->noteable_id !== null) {
            abort(403);
        }

        $note->load('user');

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'note' => $note,
            ]);
        }

        return view('admin.notes.show', [
            'note' => $note,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        // Ensure user can only update their own notes and it's a standalone note
        if ($note->user_id !== auth()->id() || $note->noteable_id !== null) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string',
            'is_pinned' => 'boolean',
        ]);

        $note->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully.',
                'note' => $note->load('user'),
            ]);
        }

        return redirect()->route('notes.index')
                        ->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        // Ensure user can only delete their own notes and it's a standalone note
        if ($note->user_id !== auth()->id() || $note->noteable_id !== null) {
            abort(403);
        }

        $note->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully.',
            ]);
        }

        return redirect()->route('notes.index')
                        ->with('success', 'Note deleted successfully.');
    }

    /**
     * Toggle pin status
     */
    public function togglePin(Note $note)
    {
        // Ensure user can only pin their own notes and it's a standalone note
        if ($note->user_id !== auth()->id() || $note->noteable_id !== null) {
            abort(403);
        }

        $note->update(['is_pinned' => !$note->is_pinned]);

        return response()->json([
            'success' => true,
            'is_pinned' => $note->is_pinned,
            'message' => $note->is_pinned ? 'Note pinned.' : 'Note unpinned.',
        ]);
    }
}

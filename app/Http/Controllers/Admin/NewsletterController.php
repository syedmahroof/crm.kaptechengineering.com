<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NewsLetter::query();

        // Apply filters
        if ($request->filled('status')) {
            if ($request->status === 'subscribed') {
                $query->where('is_subscribed', true);
            } elseif ($request->status === 'unsubscribed') {
                $query->where('is_subscribed', false);
            }
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $newsletters = $query->paginate(15);

        // Statistics
        $stats = [
            'total' => NewsLetter::count(),
            'subscribed' => NewsLetter::subscribed()->count(),
            'unsubscribed' => NewsLetter::where('is_subscribed', false)->count(),
            'this_month' => NewsLetter::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
        ];

        // Get unique sources for filter
        $sources = NewsLetter::select('source')
            ->whereNotNull('source')
            ->distinct()
            ->pluck('source');

        return view('admin.newsletters.index', [
            'newsletters' => $newsletters,
            'stats' => $stats,
            'sources' => $sources,
            'filters' => $request->only(['status', 'source', 'search', 'sort_by', 'sort_direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.newsletters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:news_letters,email',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
        ]);

        NewsLetter::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'source' => $request->source ?? 'admin',
            'is_subscribed' => true,
        ]);

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Newsletter subscription added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsLetter $newsletter)
    {
        $newsletter->load('campaigns');
        
        return view('admin.newsletters.show', [
            'newsletter' => $newsletter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsLetter $newsletter)
    {
        return view('admin.newsletters.edit', [
            'newsletter' => $newsletter,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsLetter $newsletter)
    {
        $request->validate([
            'email' => 'required|email|unique:news_letters,email,' . $newsletter->id,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
            'is_subscribed' => 'boolean',
        ]);

        $newsletter->update([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'source' => $request->source,
            'is_subscribed' => $request->is_subscribed,
        ]);

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Newsletter subscription updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsLetter $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('admin.newsletters.index')
            ->with('success', 'Newsletter subscription deleted successfully.');
    }

    /**
     * Toggle subscription status
     */
    public function toggleSubscription(NewsLetter $newsletter)
    {
        if ($newsletter->is_subscribed) {
            $newsletter->unsubscribe();
            $message = 'Newsletter subscription unsubscribed successfully.';
        } else {
            $newsletter->resubscribe();
            $message = 'Newsletter subscription resubscribed successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Bulk update newsletter subscriptions
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'action' => 'required|in:subscribe,unsubscribe,delete',
            'newsletter_ids' => 'required|array',
            'newsletter_ids.*' => 'exists:news_letters,id',
        ]);

        $newsletters = NewsLetter::whereIn('id', $request->newsletter_ids);

        switch ($request->action) {
            case 'subscribe':
                $newsletters->update(['is_subscribed' => true, 'unsubscribed_at' => null]);
                $message = 'Selected newsletters have been subscribed.';
                break;
            case 'unsubscribe':
                $newsletters->update(['is_subscribed' => false, 'unsubscribed_at' => now()]);
                $message = 'Selected newsletters have been unsubscribed.';
                break;
            case 'delete':
                $newsletters->delete();
                $message = 'Selected newsletters have been deleted.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export newsletters to CSV
     */
    public function export(Request $request)
    {
        $query = NewsLetter::query();

        // Apply same filters as index
        if ($request->filled('status')) {
            if ($request->status === 'subscribed') {
                $query->where('is_subscribed', true);
            } elseif ($request->status === 'unsubscribed') {
                $query->where('is_subscribed', false);
            }
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $newsletters = $query->orderBy('created_at', 'desc')->get();

        $filename = 'newsletters_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($newsletters) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Email',
                'First Name',
                'Last Name',
                'Status',
                'Source',
                'Subscribed At',
                'Unsubscribed At',
                'Created At'
            ]);

            // CSV data
            foreach ($newsletters as $newsletter) {
                fputcsv($file, [
                    $newsletter->email,
                    $newsletter->first_name,
                    $newsletter->last_name,
                    $newsletter->is_subscribed ? 'Subscribed' : 'Unsubscribed',
                    $newsletter->source,
                    $newsletter->created_at?->format('Y-m-d H:i:s'),
                    $newsletter->unsubscribed_at?->format('Y-m-d H:i:s'),
                    $newsletter->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

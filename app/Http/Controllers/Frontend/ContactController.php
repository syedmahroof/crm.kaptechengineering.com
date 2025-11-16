<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactMessageNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display the contact page.
     */
    public function index()
    {
        return Inertia::render('Frontend/Contact');
    }

    /**
     * Store a contact form submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Determine priority based on subject keywords
        $priority = 'medium';
        $urgentKeywords = ['urgent', 'emergency', 'asap', 'immediately'];
        $highKeywords = ['important', 'priority', 'help', 'issue'];
        
        $subjectLower = strtolower($request->subject);
        $messageLower = strtolower($request->message);
        
        if (collect($urgentKeywords)->contains(fn($keyword) => str_contains($subjectLower, $keyword) || str_contains($messageLower, $keyword))) {
            $priority = 'urgent';
        } elseif (collect($highKeywords)->contains(fn($keyword) => str_contains($subjectLower, $keyword) || str_contains($messageLower, $keyword))) {
            $priority = 'high';
        }

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
            'priority' => $priority,
        ]);

        // Send notifications to admin users
        $this->notifyAdmins($contact);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Send notifications to admin users about new contact message.
     */
    private function notifyAdmins(Contact $contact): void
    {
        try {
            // Get admin users (super-admin, admin, and manager roles)
            $adminUsers = User::role(['super-admin', 'admin', 'manager'])->get();

            if ($adminUsers->isNotEmpty()) {
                // Send notification using the Contact model's HasNotifications trait
                $contact->notifyUsers(
                    $adminUsers,
                    'contact.new',
                    'New Contact Message',
                    'New message from ' . $contact->name . ': ' . $contact->subject,
                    route('admin.contacts.show', $contact->id),
                    [
                        'priority' => $contact->priority,
                        'contact_id' => $contact->id,
                        'contact_name' => $contact->name,
                        'contact_email' => $contact->email,
                        'contact_subject' => $contact->subject,
                    ]
                );
            }
        } catch (\Exception $e) {
            // Log the error but don't break the contact form submission
            \Log::error('Failed to send contact notification: ' . $e->getMessage(), [
                'contact_id' => $contact->id,
                'exception' => $e,
            ]);
        }
    }
}

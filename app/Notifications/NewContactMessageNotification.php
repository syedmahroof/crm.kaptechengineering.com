<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contact;

    /**
     * Create a new notification instance.
     */
    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $priorityColor = match($this->contact->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray',
        };

        return (new MailMessage)
                    ->subject('New Contact Message - ' . $this->contact->subject)
                    ->greeting('New Contact Message Received')
                    ->line('A new contact message has been submitted:')
                    ->line('**From:** ' . $this->contact->name . ' (' . $this->contact->email . ')')
                    ->line('**Subject:** ' . $this->contact->subject)
                    ->line('**Priority:** ' . ucfirst($this->contact->priority))
                    ->line('**Message:** ' . $this->contact->message)
                    ->action('View Contact Message', route('admin.contacts.show', $this->contact->id))
                    ->line('Please respond to this message as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $priorityColor = match($this->contact->priority) {
            'urgent' => 'red',
            'high' => 'orange',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray',
        };

        return [
            'type' => 'contact.new',
            'title' => 'New Contact Message',
            'message' => 'New message from ' . $this->contact->name . ': ' . $this->contact->subject,
            'url' => route('admin.contacts.show', $this->contact->id),
            'priority' => $this->contact->priority,
            'priority_color' => $priorityColor,
            'contact_id' => $this->contact->id,
            'contact_name' => $this->contact->name,
            'contact_email' => $this->contact->email,
            'contact_subject' => $this->contact->subject,
        ];
    }
}

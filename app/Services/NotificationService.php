<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public static function create(
        User $user,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        string $icon = 'bell',
        string $color = 'primary'
    ) {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'action_url' => $actionUrl,
            'icon' => $icon,
            'color' => $color,
        ]);
    }

    /**
     * Create notification for lead assignment
     */
    public static function leadAssigned(User $user, $lead)
    {
        return self::create(
            $user,
            'lead_assigned',
            'New Lead Assigned',
            "A new lead '{$lead->name}' has been assigned to you.",
            route('leads.show', $lead),
            'person-plus',
            'primary'
        );
    }

    /**
     * Create notification for followup due
     */
    public static function followupDue(User $user, $followup)
    {
        return self::create(
            $user,
            'followup_due',
            'Follow-up Reminder',
            "You have a follow-up scheduled for '{$followup->lead->name}' today.",
            route('leads.show', $followup->lead),
            'calendar-check',
            'warning'
        );
    }

    /**
     * Create notification for lead status change
     */
    public static function leadStatusChanged(User $user, $lead, $oldStatus, $newStatus)
    {
        return self::create(
            $user,
            'lead_status_changed',
            'Lead Status Updated',
            "Lead '{$lead->name}' status changed from '{$oldStatus}' to '{$newStatus}'.",
            route('leads.show', $lead),
            'arrow-repeat',
            'info'
        );
    }

    /**
     * Create notification for new lead created
     */
    public static function newLeadCreated(User $user, $lead)
    {
        return self::create(
            $user,
            'lead_created',
            'New Lead Created',
            "A new lead '{$lead->name}' has been created in the system.",
            route('leads.show', $lead),
            'plus-circle',
            'success'
        );
    }

    /**
     * Create notification for note added to lead
     */
    public static function noteAdded(User $user, $lead, $note)
    {
        return self::create(
            $user,
            'note_added',
            'New Note Added',
            "A new note has been added to lead '{$lead->name}'.",
            route('leads.show', $lead),
            'chat-left-text',
            'info'
        );
    }

    /**
     * Notify all admins/managers
     */
    public static function notifyAdmins(
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        string $icon = 'bell',
        string $color = 'primary'
    ) {
        $admins = User::role(['Super Admin', 'Admin', 'Manager'])->get();

        foreach ($admins as $admin) {
            self::create($admin, $type, $title, $message, $actionUrl, $icon, $color);
        }
    }
}




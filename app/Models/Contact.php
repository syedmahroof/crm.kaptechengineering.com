<?php

namespace App\Models;

use App\Traits\HasNotifications;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, SoftDeletes, HasNotifications;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'contact_type',
        'country_id',
        'state_id',
        'district_id',
        'subject',
        'message',
        'priority',
        'admin_notes',
        'replied_at',
        'replied_by',
        'project_id',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Relationships
    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    /**
     * The enquiries that belong to the contact.
     */
    public function enquiries()
    {
        return $this->belongsToMany(Enquiry::class, 'enquiry_contact')
                    ->withPivot('contact_type', 'notes')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    // Accessors
    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray',
        };
    }

    public function getIsUrgentAttribute()
    {
        return $this->priority === 'urgent';
    }

    /**
     * Get all available contact types
     */
    public static function getContactTypes(): array
    {
        return [
            'builders_developers' => 'Builders and Developers',
            'hospitals' => 'Hospitals',
            'mep_consultants' => 'MEP Consultants',
            'architects' => 'Architects',
            'project' => 'Project',
            'plumbing_contractors' => 'Plumbing Contractors',
            'electrical_contractors' => 'Electrical Contractors',
            'hvac_contractors' => 'HVAC Contractors',
            'petrol_pump_contractors' => 'Petrol Pump Contractors',
            'civil_eng_contractors' => 'Civil Eng. Contractors',
            'fire_fighting_contractors' => 'Fire Fighting Contractors',
            'interior_designers' => 'Interior Designers',
            'swimming_pool_stp' => 'Swimming pool & STP',
            'biomedicals' => 'Biomedicals',
            'shop_retail' => 'Shop & Retail',
        ];
    }

    /**
     * Scope a query to filter by contact type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('contact_type', $type);
    }
}

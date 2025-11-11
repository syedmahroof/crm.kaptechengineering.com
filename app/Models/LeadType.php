<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadType extends Model
{
    protected $fillable = [
        'name',
        'color_code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function leads()
    {
        // Since leads table uses string for lead_type, we query by name
        return Lead::where('lead_type', $this->name);
    }
    
    public function getLeadsCountAttribute()
    {
        return $this->leads()->count();
    }
}

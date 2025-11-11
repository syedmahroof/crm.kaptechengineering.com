<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
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
        // Since leads table uses string for source, we query by name
        return Lead::where('source', $this->name);
    }
    
    public function getLeadsCountAttribute()
    {
        return $this->leads()->count();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    protected $fillable = [
        'name',
        'color_code',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'status_id');
    }
}

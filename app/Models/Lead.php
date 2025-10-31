<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'status_id',
        'assigned_to',
        'product_id',
        'branch_id',
        'source',
        'lead_type',
        'notes',
        'closing_date',
    ];

    public function status()
    {
        return $this->belongsTo(LeadStatus::class, 'status_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'description'])
            ->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function leadNotes()
    {
        return $this->hasMany(Note::class);
    }

    public function followups()
    {
        return $this->hasMany(Followup::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Builder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'pincode',
        'country_id',
        'state_id',
        'district_id',
        'location',
        'website',
        'description',
        'is_active',
        'branch_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
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

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the purchase managers for the builder.
     */
    public function purchaseManagers()
    {
        return $this->belongsToMany(Contact::class, 'builder_purchase_manager', 'builder_id', 'contact_id')
                    ->withTimestamps();
    }
}

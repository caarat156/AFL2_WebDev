<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $primaryKey = 'workshop_id';

    protected $fillable = [
        'title',
        'description',
        'price',
        'date',
        'time',
        'location',
        'capacity',
        'image'
    ];

public function registrations()
{
    return $this->hasMany(WorkshopRegistration::class, 'workshop_id');
}

// Relasi ke guest registration
public function guestRegistrations()
{
    return $this->hasMany(GuestWorkshopRegistration::class, 'workshop_id');
}
}

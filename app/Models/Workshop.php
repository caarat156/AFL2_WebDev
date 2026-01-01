<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $table = 'workshops';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'description',
        'price',
        'date',
        'time',
        'location',
        'capacity',
        'image',
    ];

    /**
     * Get the route key for implicit model binding
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function registrations()
    {
        return $this->hasMany(WorkshopRegistration::class, 'workshop_id', 'id');
    }

    public function guestRegistrations()
    {
        return $this->hasMany(GuestWorkshopRegistration::class, 'workshop_id', 'id');
    }
}

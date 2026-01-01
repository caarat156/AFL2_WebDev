<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guest';
    protected $primaryKey = 'guest_id';

    protected $fillable = [
        'guest_email',
        'guest_phone',
    ];

    public function workshopRegistrations()
    {
        return $this->hasMany(
            GuestWorkshopRegistration::class,
            'guest_id'
        );
    }
}


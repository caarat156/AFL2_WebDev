<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestWorkshopRegistration extends Model
{
    protected $table = 'guest_workshop_registration';
    protected $primaryKey = 'guest_workshop_registration_id';

    protected $fillable = [
        'guest_id',
        'workshop_id',
        'registration_date',
        'payment_status',
        'payment_method',
        'payment_amount',
        'payment_date'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }
}


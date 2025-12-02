<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopRegistration extends Model
{
    protected $table = 'workshop_registration';
    protected $primaryKey = 'workshop_registration_id';

    protected $fillable = [
        'workshop_id',
        'user_id',
        'registration_date',
        'payment_status',
        'payment_method',
        'payment_amount',
        'payment_date'
    ];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'package_id',
        'booking_quantity',
        'note',
        'status',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingPayment()
    {
        return $this->hasOne(BookingPayment::class);
    }
}

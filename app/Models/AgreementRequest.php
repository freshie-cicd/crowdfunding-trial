<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'shipping_address',
        'courier_service',
        'courier_branch',
        'phone',
        'status',
        'note',
    ];
}

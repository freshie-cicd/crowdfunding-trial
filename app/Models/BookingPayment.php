<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    use HasFactory;

    protected $fillable =[
        'booking_id',
        'payment_method',
        'payment_date',
        'payment_document',
        'document_two',
        'document_three',
        'note'
    ];
}

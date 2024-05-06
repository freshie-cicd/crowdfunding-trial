<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_code',
        'package_to_withdraw',
        'capital_withdrawal_amount',
        'package_after_withdrawal',
        'after_withdrawal_amount',
        'profit_withdrawal_amount',
        'is_bank_detail_correct',
        'note',
        'status',
    ];
}

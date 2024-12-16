<?php

namespace App\Models\Models\Administrator;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'address',
        'phone',
        'email',
        'light_logo',
        'dark_logo',
        'favicon',
        'account_holder_name',
        'bank_name',
        'branch_name',
        'account_number',
        'ifsc_code',
        'swift_code',
        'account_type',
        'currency',
        'whatsapp',
        'youtube',
        'facebook',
        'twitter',
        'linkedin',
    ];
}

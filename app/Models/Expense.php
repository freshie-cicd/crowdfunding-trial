<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'head',
        'amount',
        'submitted_by',
        'memo',
        'date',
        'is_approved',
        'approved_by',
        'type',
        'asset_id',
        'note',
    ];
}

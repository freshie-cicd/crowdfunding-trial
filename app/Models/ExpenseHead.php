<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseHead extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent',
        'name',
        'status',
        'note',
    ];
}

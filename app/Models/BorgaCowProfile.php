<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorgaCowProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_date',
        'price',
        'hasil',
        'transport_cost',
        'weight',
        'color',
        'breed',
        'age',
        'adviser',
        'hat',
        'photo',
        'note',
        'status',
    ];
}

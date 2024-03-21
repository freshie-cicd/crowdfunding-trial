<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
      'package_id',
      'name',
      'description',
      'purchase_price',
      'color',
      'location',
      'asset_code',
      'status',
      'note',
    ];
}

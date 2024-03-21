<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectBatch extends Model
{
    use HasFactory;

    protected $fillable = [
      'proejct_id',
      'name',
      'description',
      'code',
      'cover',
      'ending_date',
      'note',
    ];
}

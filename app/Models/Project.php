<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'status',
        'cover_photo',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}

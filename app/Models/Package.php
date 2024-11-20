<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'code',
        'value',
        'capacity',
        'status',
        'note',
        'maturity',
        'return_amount',
        'migration_package_id',
        'start_date',
        'end_date',
        'cover_url',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

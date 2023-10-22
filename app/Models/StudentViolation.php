<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentViolation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'violation_id',
        'violator_id',
        'guard_id',
        'status',
        'note',
    ];
}

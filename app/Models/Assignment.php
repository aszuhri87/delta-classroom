<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'task_id',
        'student_id',
        'detail',
        'score',
    ];

    protected $dates = ['deleted_at'];
}

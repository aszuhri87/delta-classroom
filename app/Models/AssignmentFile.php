<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignmentFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'name',
        'file_path',
    ];

    protected $dates = ['deleted_at'];
}

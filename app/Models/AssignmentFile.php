<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'name',
        'file_path',
    ];
}

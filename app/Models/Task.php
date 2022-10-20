<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'group_id',
        'name',
        'detail',
        'file_path',
        'expired_at',
        'division_id',
    ];

    protected $dates = ['deleted_at'];
}

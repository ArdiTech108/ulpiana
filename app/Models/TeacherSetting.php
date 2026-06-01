<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSetting extends Model
{
    protected $fillable = [
        'user_id',
        'display_name',
        'notifications',
        'language_code',
    ];
}

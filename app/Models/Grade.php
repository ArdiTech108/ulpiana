<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'teacher_user_id',
        'student_name',
        'subject',
        'grade_value',
        'comment_text',
        'is_published',
    ];
}

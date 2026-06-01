<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'teacher_id',
        'teacher_name',
        'teacher_subject',
        'teacher_email',
        'slot_time',
        'parent_name',
        'student_name',
        'parent_email',
        'topic',
        'status',
        'created_by_user_id',
    ];
}

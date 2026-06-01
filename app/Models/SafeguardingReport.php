<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafeguardingReport extends Model
{
    protected $fillable = [
        'reporter_name',
        'reporter_email',
        'is_anonymous',
        'category',
        'message_text',
        'status',
        'assigned_to_user_id',
    ];
}

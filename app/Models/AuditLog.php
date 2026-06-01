<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'actor_user_id',
        'action_name',
        'target_type',
        'target_id',
        'details_json',
    ];
}

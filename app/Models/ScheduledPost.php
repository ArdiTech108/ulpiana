<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledPost extends Model
{
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'source_prompt',
        'title',
        'content',
        'audience',
        'status',
        'publish_at',
        'published_at',
        'created_by_user_id',
    ];
}

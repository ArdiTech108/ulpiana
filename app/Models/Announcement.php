<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'content',
        'audience',
        'created_by_user_id',
    ];
}

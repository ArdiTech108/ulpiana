<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public $timestamps = true;
    const UPDATED_AT = null;

    protected $fillable = [
        'title',
        'category',
        'file_path',
        'uploaded_by_user_id',
    ];
}

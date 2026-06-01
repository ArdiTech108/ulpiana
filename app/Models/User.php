<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = true;
    const UPDATED_AT = null; // No updated_at column in users table

    protected $fillable = [
        'full_name',
        'email',
        'google_id',
        'password_hash',
        'role',
        'teacher_id',
        'teacher_subject',
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Get the password for the user (for legacy compatibility we store password_hash, 
     * but Laravel's Auth expects getAuthPassword to return the hashed password)
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}

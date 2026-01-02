<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- MAKE SURE THIS LINE IS CORRECT

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // <--- AND THIS LINE

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'id_number',
        'office_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- ADDED METHOD FOR ROLE CHECK ---
    public function hasRole($roleId): bool
    {
        return $this->role_id == $roleId;
    }

    public function assignedOffice()
    {
        // links 'office_id' on users table to 'id' on offices table
        return $this->belongsTo(Office::class, 'office_id');
    }
}

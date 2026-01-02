<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Add this use statement

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function complaints(): HasMany
    {

        return $this->hasMany(Complaint::class, 'assigned_office_id');
    }

    public function personnel()
    {
        // An Office has many Users (Personnel).
        // It assumes the foreign key 'office_id' exists on the 'users' table.
        return $this->hasMany(User::class, 'office_id');
    }


}

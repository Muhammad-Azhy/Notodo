<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

   

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function problems()
    {
        return $this->hasMany(Problem::class);
    }

    public function references()
    {
        return $this->hasManyThrough(Reference::class, Problem::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Problem::class);
    }

    public function attachments()
    {
        return $this->hasManyThrough(Attachment::class, Problem::class);
    }
     public function getJWTCustomClaims()
    {
        return [];
    }
}

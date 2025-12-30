<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Userlist extends Authenticatable
{
    protected $table = 'userlists';

    protected $fillable = [
        'name',
        'email',
        'number',
        'password',
        'role_id',
    ];

   

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Auto hash password
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }




}

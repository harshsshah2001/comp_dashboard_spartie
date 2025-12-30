<?php

namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;

use Illuminate\Database\Eloquent\Model;

class Permission extends SpatiePermission
{

    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];
}

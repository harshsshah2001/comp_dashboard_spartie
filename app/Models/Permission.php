<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class Permission extends SpatiePermission implements PermissionContract
{
    protected $fillable = [
        'name',
        'guard_name',
        'description',
    ];

    // ✅ FORCE DEFAULT GUARD
    protected $attributes = [
        'guard_name' => 'userlist',
    ];
}

<?php

declare(strict_types=1);

namespace Blockpc\Models;

use Spatie\Permission\Models\Role as ModelsRole;

final class Role extends ModelsRole
{
    const SUDO = 'sudo';
    const ADMIN = "admin";
    const USER = "user";

    const ROLES_NOT_DELETES = [ 
        self::SUDO, 
        self::ADMIN, 
        self::USER, 
    ];

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'description',
    ];
}
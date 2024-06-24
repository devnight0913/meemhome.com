<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Role
{
    /**
     * Constant representing an admin role id.
     *
     * @var int
     */
    public const SUPER_ADMIN = 1;



    /**
     * Constant representing an admin role id.
     *
     * @var int
     */
    public const ADMIN = 2;

    /**
     * Constant representing a user role id.
     *
     * @var int
     */
    public const USER = 3;


    public static $roleTexts = [
        self::SUPER_ADMIN => 'Super Admin',
        self::ADMIN => 'Admin',
        self::USER => 'User',
    ];

    /**
     * Get roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getRoles(): Collection
    {
        return collect([
            (object)[
                'id' => self::ADMIN,
                'name' => self::$roleTexts[self::ADMIN],
                'selected' => false,
            ],
            (object)[
                'id' => self::USER,
                'name' => self::$roleTexts[self::USER],
                'selected' => true,
            ],
        ]);
    }
}

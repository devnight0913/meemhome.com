<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Status
{

    /**
     * Constant representing an active status id.
     *
     * @var int
     */
    public const ACTIVE = 1;

    /**
     * Constant representing a drafted status id.
     *
     * @var int
     */
    public const DRAFTED = 2;


    public static $statusTexts = [
        self::ACTIVE => 'Active',
        self::DRAFTED => 'Drafted',
    ];

    /**
     * Get Statuses.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getStatuses(): Collection
    {
        return collect([
            (object)[
                'id' => self::ACTIVE,
                'name' => self::$statusTexts[self::ACTIVE],
            ],
            (object)[
                'id' => self::DRAFTED,
                'name' => self::$statusTexts[self::DRAFTED],
            ],
        ]);
    }
}

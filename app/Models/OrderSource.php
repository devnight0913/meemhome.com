<?php

namespace App\Models;

use App\Services\Strings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSource extends Model
{
    use HasFactory;

    const WEBSITE = 1;
    const ANDROID_APP = 2;
    const IOS_APP = 3;
    const WINDOWS_PHONE_APP = 4;
    const DESKTOP_APP = 5;
    const STORE = 6;


    public static $sources = [
        self::WEBSITE => Strings::WEBSITE,
        self::ANDROID_APP => Strings::ANDROID_APP,
        self::IOS_APP => Strings::IOS_APP,
        self::WINDOWS_PHONE_APP => Strings::WINDOWS_PHONE_APP,
        self::DESKTOP_APP => Strings::DESKTOP_APP,
        self::STORE => Strings::STORE,
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'icon_view'
    ];

    public static $icons = [
        self::WEBSITE => '<i class="uicon ic_br_globe"></i>',
        self::ANDROID_APP => '<i class="uicon ic_rr_smartphone"></i>',
        self::IOS_APP => '<i class="uicon ic_rr_smartphone"></i>',
        self::WINDOWS_PHONE_APP => '<i class="uicon ic_rr_smartphone"></i>',
        self::DESKTOP_APP => '<i class="uicon ic_rr_screen"></i>',
        self::STORE => '<i class="uicon ic_rr_shop"></i>',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function getIconViewAttribute()
    {
        return self::$icons[$this->id];
    }
}

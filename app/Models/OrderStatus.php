<?php

namespace App\Models;

use App\Services\Strings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    const PENDING = 1;
    const DELIVERED = 2;
    const CANCELLED = 3;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_status'
    ];

    public static $statuses = [
        self::PENDING => Strings::PENDING,
        self::DELIVERED => Strings::DELIVERED,
        self::CANCELLED => Strings::CANCELLED
    ];

    public static $icons = [
        self::PENDING => '<span class="material-symbols-sharp fs-6">timer</span>',
        self::DELIVERED => '<span class="material-symbols-sharp fs-6">task_alt</span>',
        self::CANCELLED => '<span class="material-symbols-sharp fs-6">cancel</span>'
    ];
    public static $userIcons = [
        self::PENDING => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon-sm me-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        self::DELIVERED => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon-sm me-1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        self::CANCELLED => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hero-icon-sm me-1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
    ];

    public static $colors = [
        self::PENDING => 'bg-warning',
        self::DELIVERED => 'bg-success',
        self::CANCELLED => 'bg-danger'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function getIconAttribute($attr)
    {
        return self::$icons[$this->id];
    }
    public function getFullStatusAttribute()
    {
        return '<span class="badge rounded-0 small fw-normal ' . self::$colors[$this->id] . '">' . self::$icons[$this->id] . ' ' . self::$statuses[$this->id] . '</span>';
    }
    public function getUserFullStatusAttribute()
    {
        return '<span class="badge rounded-0 fw-normal d-flex align-items-center ' . self::$colors[$this->id] . '">' . self::$userIcons[$this->id] . ' ' . self::$statuses[$this->id] . '</span>';
    }
}

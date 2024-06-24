<?php

namespace App\Models;


use App\Services\Strings;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;


    const CACHE_KEY = "areas";
    const CACHE_TTL = 60 * 60 * 72;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'fee',
        'time',
        'is_active',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'view_fee',
        'view_time',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    /**
     * get view fee.
     *
     * @return string
     */
    public function getViewFeeAttribute(): string
    {
        return usd_money_format($this->fee);
    }

    /**
     * get view delivery time.
     *
     * @return string
     */
    public function getViewTimeAttribute(): string
    {
        if ($this->time == 60) return "1 h";
        return $this->time > 60 ? intdiv($this->time, 60) . " h " . ($this->time  % 60) . " min" : $this->time . " min";
    }
    /**
     * get status.
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        return $this->is_active ? Strings::ACTIVE : Strings::INACTIVE;
    }
}

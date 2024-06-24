<?php

namespace App\Models;

use App\Services\Strings;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;


    protected $fillable = [
        'code',
        'percentage',
        'description',
        'is_active',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
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
     * get status.
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        return $this->is_active ? Strings::ACTIVE : Strings::INACTIVE;
    }
}

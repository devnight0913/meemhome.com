<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'display_subtotal',
        'display_total',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
    public function getDisplaySubtotalAttribute(): string
    {
        return usd_money_format($this->price);
    }
    public function getDisplayTotalAttribute(): string
    {
        return usd_money_format($this->price * $this->quantity);
    }
}

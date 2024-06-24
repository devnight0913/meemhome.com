<?php

namespace App\Models;

use App\Services\Strings;
use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
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
        'display_date',
        'display_date_created_at',
        'type',
        'display_total',
        'display_subtotal',
        'display_delivery_fee',
        'display_discount',
        'date_year_month',
    ];

    /**
     * Scope a query to search users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCustomer(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;
        return $query->Where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
    }
    /**
     * Scope a query to search users
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;
        return $query->where('number', 'LIKE', "%{$search}%")
            ->orWhere('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%");
    }
    /**
     * Override the boot function from Laravel so that
     * we give the model a new UUID when we create it.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::deleted(function ($order) {
            $order->order_detail->each->delete();
        });
    }


    public function order_detail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class)->withTrashed();
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class)->withTrashed();
    }

    public function order_status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }


    public function order_source(): BelongsTo
    {
        return $this->belongsTo(OrderSource::class);
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class)->withTrashed();
    }

    public function getDisplayDateAttribute()
    {
        return $this->created_at->isToday() ?
            Carbon::parse($this->created_at)->diffForHumans()
            : Carbon::parse($this->created_at)->format(config('app.default_datetime_format'));
    }

    public function getDisplayDateCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format(config('app.default_datetime_format'));
    }
    public function getDisplayDateCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->format('j F Y');
    }

    public function getDisplayDeliveredAtAttribute()
    {
        return Carbon::parse($this->delivered_at)->format('j F Y H:i:s');
    }

    public function getDisplayTimeCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->format('H:i');
    }
    public function getTypeAttribute()
    {
        return $this->is_delivery ? Strings::DELIVERY : Strings::PICKUP;
    }
    public function getDateYearMonthAttribute(): string
    {
        return Carbon::parse($this->created_at)->format('M-Y');
    }
    public function getDisplaySubtotalAttribute(): string
    {
        return usd_money_format($this->subtotal);
    }
    public function getDisplayDeliveryFeeAttribute(): string
    {
        return usd_money_format($this->delivery_fee);
    }
    public function getDisplayTotalAttribute(): string
    {
        return usd_money_format($this->total);
    }

    public function getOrderDetailsTotalAttribute(): float
    {
        return $this->order_detail->sum(function ($query) {
            return $query->subtotal * $query->quantity;
        });
    }
    public function getDisplayDiscountAttribute(): string
    {
        return "-" . usd_money_format($this->discount);
    }
    public function getDisplayOrderDetailsTotalAttribute(): string
    {
        return usd_money_format($this->order_details_total);
    }
}

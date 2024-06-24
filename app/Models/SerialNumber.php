<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SerialNumber extends Model
{
    use HasFactory;

    /**
     * Scope a query to search
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search) return $query;
        return $query->where('serial_numbers', 'LIKE', "%{$search}%");
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }

    public function getSerialNumbersViewAttribute()
    {
        return Str::limit($this->serial_numbers, 40, '…');
    }

    public function getWarrantyEndDateViewAttribute()
    {
        return Carbon::parse($this->warranty_end_date)->format('d F Y');
    }

    public function getPurchaseDateViewAttribute()
    {
        return !is_null($this->purchase_date) ? Carbon::parse($this->purchase_date)->format('d F Y') : null;
    }


    public function getExplodedSerialNumbersAttribute()
    {
        return implode(PHP_EOL,  explode(', ', $this->serial_numbers));
    }
}

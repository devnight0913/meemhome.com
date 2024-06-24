<?php

namespace App\Traits;

use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


trait HasStatus
{
    /**
     * Scope a query to only include active.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status_id', Status::ACTIVE);
    }

    /**
     * Scope a query to only include drafted.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDrafted(Builder $query): Builder
    {
        return $query->where('status_id', Status::DRAFTED);
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        return Status::$statusTexts[$this->status_id];
    }

    /**
     * Get is active.
     *
     * @return bool
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status_id == Status::ACTIVE;
    }

    /**
     * Get is drafted.
     *
     * @return bool
     */
    public function getIsDraftedAttribute(): bool
    {
        return $this->status_id == Status::DRAFTED;
    }
}

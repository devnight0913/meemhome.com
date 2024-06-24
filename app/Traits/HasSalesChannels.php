<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;


trait HasSalesChannels
{
    /**
     * Scope a query to only include pos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePos(Builder $query): Builder
    {
        return $query->where('pos', true);
    }

    /**
     * Scope a query to only include website.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWebsite(Builder $query): Builder
    {
        return $query->where('website', true);
    }

    /**
     * Scope a query to only include website.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAndroidApp(Builder $query): Builder
    {
        return $query->where('android_app', true);
    }

    /**
     * Scope a query to only include website.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIosApp(Builder $query): Builder
    {
        return $query->where('ios_app', true);
    }
}

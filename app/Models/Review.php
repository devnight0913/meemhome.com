<?php

namespace App\Models;

use App\Traits\HasUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    use HasFactory, HasUuid;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getDisplayDateAttribute()
    {
        return $this->created_at->isToday() ?
            Carbon::parse($this->created_at)->diffForHumans()
            : Carbon::parse($this->created_at)->format(config('app.default_datetime_format'));
    }

    public function getCommentLimitAttribute()
    {
        return Str::limit($this->comment, 100);
    }
}

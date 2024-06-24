<?php

namespace App\Models;

use App\Services\Strings;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class Banner extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    public const CACHE_KEY = "banners";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_path',
        'sort_order',
        'url',
        'alt',
        'target',
        'is_active'
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'image_url',
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
     * Update the image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->store(
                    'banner-image',
                )
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }


    /**
     * Get the  to the banner's url target.
     *
     * @return string
     */
    public function getUrlTargetAttribute(): string
    {
        if (is_null($this->target)) return "_self";
        return $this->target;
    }

    /**
     * Get the  to the banner's image alt.
     *
     * @return string
     */
    public function getImageAltAttribute(): string
    {
        if (is_null($this->alt)) return config('app.name');
        return $this->alt;
    }

    /**
     * Get the URL to the banner's image.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return route('image.show', ['path' => $this->image_path, 'w' => 1140, 'h' => 380, 'fit' => 'crop', 'bg' => 'white', 'fm' => 'webp']);
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

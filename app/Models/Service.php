<?php

namespace App\Models;

use App\Services\Strings;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;
    use HasUuid;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'sort_order',
        'is_active'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url',
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
     * Update the  image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->store(
                    'service-image',
                )
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }


    /**
     * Get the URL to the image.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image_path) return asset('images/webp/placeholder.webp');
        return route('image.show', ['path' => $this->image_path, 'w' => 600, 'h' => 600, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }
    public function getPageDescriptionAttribute()
    {
        return html_entity_decode(strip_tags(Str::limit($this->description, 319)));
    }

    /**
     * Get the URL to the image.
     *
     * @return string
     */
    public function getImageUrlOgAttribute(): string
    {
        if (!$this->image_path) return asset('images/webp/placeholder.webp');
        return route('image.show', ['path' => $this->image_path, 'fm' => 'webp']);
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

    public function getPageKeywordsAttribute()
    {
        return Str::limit(str_replace(' ', ', ', $this->title), 159);
    }
    /**
     * get url.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return route('services.show', $this->id);
    }

    public function getDateModifiedAttribute()
    {
        return gmdate('Y-m-d\TH:i:s\Z', strtotime($this->updated_at));
    }
}

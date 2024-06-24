<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Image extends Model
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
        'image_url',
        'thumbnail_url',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    /**
     * Get the URL to the item's image.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        return route('image.show', ['path' => $this->image_path, 'w' => 650, 'h' => 650, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }

    /**
     * Get the URL to the item's image small.
     *
     * @return string
     */
    public function getThumbnailUrlAttribute(): string
    {
        return route('image.show', ['path' => $this->image_path, 'w' => 70, 'h' => 70, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }

    /**
     * Insert image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function insertImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->store('item-image'),
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    /**
     * Delete the item's image.
     *
     * @return void
     */
    public function removeFromStorage()
    {
        Storage::disk('public')->delete($this->image_path);
    }


    /**
     * Get the URL to the item's image small.
     *
     * @return string
     */
    public function getImageUrlOriginalAttribute(): string
    {
        return route('image.show', ['path' => $this->image_path]);;
    }
}

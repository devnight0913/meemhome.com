<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImage
{

    /**
     * Update the item's image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function updateImage(UploadedFile $image)
    {
        tap($this->image_path, function ($previous) use ($image) {
            $this->forceFill([
                'image_path' => $image->store(
                    'item-image',
                )
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }
    /**
     * Get the URL to the item's image.
     *
     * @return string
     */
    public function getImageDownloadAttribute(): string
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'fm' => 'jpg']);
    }
    /**
     * Get the URL to the item's image.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'w' => 650, 'h' => 650, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }

    /**
     * Get the URL to the item's image.
     *
     * @return string
     */
    public function getThumbnailImageUrlAttribute(): string
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'w' => 370, 'h' => 370, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }


    /**
     * Get the URL to the item's image.
     *
     * @return string
     */
    public function getSmThumbnailImageUrlAttribute(): string
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'w' => 70, 'h' => 70, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }


    /**
     * Delete the item's image.
     *
     * @return void
     */
    public function deleteImage()
    {
        Storage::disk('public')->delete($this->image_path);

        $this->forceFill([
            'image_path' => null,
        ])->save();
    }
}

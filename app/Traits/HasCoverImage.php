<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasCoverImage
{


    /**
     * Update the image.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     */
    public function updateCoverImage(UploadedFile $image)
    {
        tap($this->cover_image_path, function ($previous) use ($image) {
            $this->forceFill([
                'cover_image_path' => $image->store('covers')
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }
    /**
     * Get the URL to the cover.
     *
     * @return string|null
     */
    public function getCoverImageUrlAttribute(): string|null
    {
        return $this->cover_image_path
            ? route('image.show', ['path' => $this->cover_image_path, 'fm' => 'webp'])
            : null;
    }

    /**
     * Delete the cover image.
     *
     * @return void
     */
    public function deleteCoverImage()
    {
        if (!$this->cover_image_path) return;
        Storage::disk('public')->delete($this->cover_image_path);

        $this->forceFill([
            'cover_image_path' => null,
        ])->save();
    }
}

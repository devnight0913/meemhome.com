<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasIcon
{

    /**
     * Update the icon.
     *
     * @param \Illuminate\Http\UploadedFile $icon
     * @return void
     */
    public function updateIcon(UploadedFile $icon)
    {
        tap($this->image_path, function ($previous) use ($icon) {
            $this->forceFill([
                'image_path' => $icon->store('icons')
            ])->save();

            if ($previous) {
                Storage::disk('public')->delete($previous);
            }
        });
    }

    /**
     * Get the URL to the icon.
     *
     * @return string|null
     */
    public function getIconUrlAttribute(): string|null
    {
        return $this->cover_image_pat
            ? route('image.show', ['path' => $this->cover_image_pat, 'w' => 40, 'h' => 40, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp'])
            : null;
    }
    /**
     * Get the URL to the icon.
     *
     * @return string|null
     */
    public function getSelectIconUrlAttribute(): string|null
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'w' => 40, 'h' => 40, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }

    /**
     * Get the URL to the category's image.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'w' => 650, 'h' => 650, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }

    /**
     * Get the URL to the category's image.
     *
     * @return string
     */
    public function getImageUrlOriginalAttribute(): string
    {
        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path]);
    }


    /**
     * Get the URL to the category's image.
     *
     * @return string
     */
    public function getSplideSlideImageAttribute(): string
    {

        $path = $this->image_path ?? "placeholder.webp";
        return route('image.show', ['path' => $path, 'w' => 400, 'h' => 400, 'fit' => 'fill-max', 'bg' => 'white', 'fm' => 'webp']);
    }

    /**
     * Delete the icon.
     *
     * @return void
     */
    public function deleteIcon()
    {
        if (!$this->image_path) return;
        Storage::disk('public')->delete($this->image_path);
        $this->forceFill([
            'image_path' => null,
        ])->save();
    }
}

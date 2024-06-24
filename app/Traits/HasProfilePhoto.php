<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;

trait HasProfilePhoto
{
    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->store(
                    'profile-photos'
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    public function getProfilePhotoUrlSmallAttribute()
    {
        return $this->profile_photo_path
            ? route('image.show', ['path' => $this->profile_photo_path, 'w' => 30, 'h' => 30, 'fit' => 'crop', 'fm' => 'webp'])
            : $this->defaultProfilePhotoUrl();
    }
    public function getProfilePhotoUrlMediumAttribute()
    {
        return $this->profile_photo_path
            ? route('image.show', ['path' => $this->profile_photo_path, 'w' => 100, 'h' => 100, 'fit' => 'crop', 'fm' => 'webp'])
            : $this->defaultProfilePhotoUrl();
    }

    public function getProfilePhotoUrlLargeAttribute()
    {
        return $this->profile_photo_path
            ? route('image.show', ['path' => $this->profile_photo_path, 'w' => 700, 'h' => 700, 'fit' => 'crop', 'fm' => 'webp'])
            : $this->defaultProfilePhotoUrl();
    }
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? route('image.show', ['path' => $this->profile_photo_path])
            : $this->defaultProfilePhotoUrl();
    }

    public function deleteProfilePhoto()
    {
        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    protected function defaultProfilePhotoUrl()
    {
        // $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
        //     return mb_substr($segment, 0, 1);
        // })->join(' '));

        // return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
        return asset('images/webp/user.webp');
    }

    protected function profilePhotoDisk(): string
    {
        return 'public';
    }
}

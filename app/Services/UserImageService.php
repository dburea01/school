<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserImageService
{
    public function store(User $user, UploadedFile $file): array
    {
        $avatarPath = "users/{$user->id}/avatar.webp";
        $photoPath = "users/{$user->id}/photo.webp";

        Image::fromUpload($file)
            ->cover(50, 50)
            ->toWebp()
            ->quality(80)
            ->storePubliclyAs(
                dirname($avatarPath),
                basename($avatarPath),
                'public'
            );

        Image::fromUpload($file)
            ->scale(width: 400)
            ->toWebp()
            ->quality(85)
            ->storePubliclyAs(
                dirname($photoPath),
                basename($photoPath),
                'public'
            );

        return [
            'avatar_path' => $avatarPath,
            'photo_path' => $photoPath,
        ];
    }

    public function delete(User $user): void
    {
        Storage::disk('public')->deleteDirectory(
            "users/{$user->id}"
        );
    }

    public function removePhoto(User $user): void
    {
        Storage::disk('public')->delete("users/{$user->id}/avatar.webp");
        Storage::disk('public')->delete("users/{$user->id}/photo.webp");
    }
}

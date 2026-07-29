<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Image;

class UserImageService
{
    public function store(User $user, UploadedFile $file): array
    {
        $avatarPath = "users/{$user->id}/avatar.webp";
        $photoPath = "users/{$user->id}/photo.webp";

        Image::fromUpload($file)
            ->cover(150, 150)
            ->toWebp()
            ->quality(80)
            ->storePubliclyAs(
                dirname($avatarPath),
                basename($avatarPath),
                'public'
            );

        Image::fromUpload($file)
            ->scale(width: 800)
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
}
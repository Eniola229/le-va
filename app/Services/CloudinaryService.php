<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CloudinaryService
{
    public function uploadImage(mixed $file, string $folder = 'lev-av/images'): array
    {
        $result = Cloudinary::upload($file->getRealPath(), [
            'folder' => $folder,
            'transformation' => [['quality' => 'auto', 'fetch_format' => 'auto']],
        ]);

        return [
            'url'       => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ];
    }

    public function uploadVideo(mixed $file, string $folder = 'lev-av/videos'): array
    {
        $result = Cloudinary::uploadVideo($file->getRealPath(), [
            'folder'           => $folder,
            'resource_type'    => 'video',
            'eager'            => [['streaming_profile' => 'hd', 'format' => 'm3u8']],
            'eager_async'      => true,
        ]);

        return [
            'url'       => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ];
    }

    public function uploadFile(mixed $file, string $folder = 'lev-av/resources'): array
    {
        $result = Cloudinary::uploadFile($file->getRealPath(), [
            'folder'        => $folder,
            'resource_type' => 'raw',
        ]);

        return [
            'url'       => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ];
    }

    public function delete(string $publicId, string $resourceType = 'image'): void
    {
        Cloudinary::destroy($publicId, ['resource_type' => $resourceType]);
    }
}
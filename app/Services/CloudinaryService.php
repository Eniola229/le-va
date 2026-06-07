<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
            'url' => ['secure' => true],
        ]);

        $this->cloudinary = new Cloudinary();
    }

    public function uploadImage(UploadedFile $file, string $folder = 'orderer/products'): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder'        => $folder,
                'resource_type' => 'image',
                'transformation' => [
                    'quality'      => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]);

            if (empty($result['secure_url'])) {
                Log::error('Cloudinary uploadImage failed - empty response', [
                    'folder' => $folder,
                    'file'   => $file->getClientOriginalName(),
                    'result' => json_encode($result),
                ]);
                throw new \RuntimeException('Image upload failed — Cloudinary returned an empty response.');
            }

            return [
                'url'       => $result['secure_url'],
                'public_id' => $result['public_id'],
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary uploadImage exception: ' . $e->getMessage(), [
                'folder' => $folder,
                'file'   => $file->getClientOriginalName(),
            ]);
            throw new \RuntimeException('Image upload failed: ' . $e->getMessage());
        }
    }

    public function uploadVideo(UploadedFile $file, string $folder = 'orderer/videos'): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder'        => $folder,
                'resource_type' => 'video',
            ]);

            if (empty($result['secure_url'])) {
                Log::error('Cloudinary uploadVideo failed - empty response', [
                    'folder' => $folder,
                    'file'   => $file->getClientOriginalName(),
                ]);
                throw new \RuntimeException('Video upload failed — Cloudinary returned an empty response.');
            }

            return [
                'url'       => $result['secure_url'],
                'public_id' => $result['public_id'],
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary uploadVideo exception: ' . $e->getMessage(), [
                'folder' => $folder,
                'file'   => $file->getClientOriginalName(),
            ]);
            throw new \RuntimeException('Video upload failed: ' . $e->getMessage());
        }
    }

    public function uploadDocument(UploadedFile $file, string $folder = 'orderer/documents'): array
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder'        => $folder,
                'resource_type' => 'raw',
            ]);

            if (empty($result['secure_url'])) {
                Log::error('Cloudinary uploadDocument failed - empty response', [
                    'folder' => $folder,
                    'file'   => $file->getClientOriginalName(),
                ]);
                throw new \RuntimeException('Document upload failed — Cloudinary returned an empty response.');
            }

            return [
                'url'       => $result['secure_url'],
                'public_id' => $result['public_id'],
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary uploadDocument exception: ' . $e->getMessage(), [
                'folder' => $folder,
                'file'   => $file->getClientOriginalName(),
            ]);
            throw new \RuntimeException('Document upload failed: ' . $e->getMessage());
        }
    }

    public function delete(string $publicId, string $resourceType = 'image'): bool
    {
        try {
            $this->cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => $resourceType,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed: ' . $e->getMessage(), [
                'public_id'     => $publicId,
                'resource_type' => $resourceType,
            ]);
            return false;
        }
    }
}
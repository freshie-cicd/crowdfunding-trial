<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService
{
    private $disk;

    /**
     * Constructs a new FileStorageService.
     */
    public function __construct()
    {
        $this->disk = config('filesystems.default', 'public');
    }

    /**
     * Uploads a file to the specified path.
     *
     * @return string Full path to the uploaded file or URL (for s3)
     */
    public function uploadFile(UploadedFile $file, string $path): string
    {
        try {
            $path = trim($path, '/').'/';
            $fileName = $this->generateFileName($file);
            $fullPath = $path.$fileName;

            if ('s3' === $this->disk) {
                Storage::disk('s3')->put($fullPath, file_get_contents($file));

                return Storage::disk('s3')->url($fullPath);
            }

            Storage::disk('public')->put($fullPath, file_get_contents($file));

            return $fullPath;
        } catch (\Exception $e) {
            throw new \Exception('File upload failed: '.$e->getMessage());
        }
    }

    /**
     * Deletes a file from storage if it exists.
     *
     * @return bool True if deleted, false if not found
     */
    public function deleteFile(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }

    /**
     * Uploads a new file and deletes the old one if provided.
     *
     * @return string Full path to the new file or URL
     */
    public function replaceFile(?string $oldFile, UploadedFile $newFile, string $path): string
    {
        if ($oldFile) {
            $this->deleteFile($oldFile);
        }

        return $this->uploadFile($newFile, $path);
    }

    /**
     * Generates a unique file name using UUID and timestamp.
     *
     * @return string Generated file name
     */
    private function generateFileName(UploadedFile $file): string
    {
        return Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
    }
}

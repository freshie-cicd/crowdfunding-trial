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
     *
     * Sets the `$disk` property to the default filesystem disk, which is
     * determined by the `FILESYSTEM_DRIVER` environment variable. If this
     * variable is not set, the value defaults to 'local'.
     */
    public function __construct()
    {
        $this->disk = config('filesystems.default', 'local');
    }

    public function uploadFile(UploadedFile $file, string $path): string
    {
        try {
            // Ensure path starts and ends with appropriate slashes
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
            throw new \Exception('File upload failed');
        }
    }

    private function generateFileName(UploadedFile $file): string
    {
        return Str::uuid().'_'.time().'.'.$file->getClientOriginalExtension();
    }
}

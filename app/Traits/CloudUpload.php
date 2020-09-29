<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Upload file to cloud
 */
trait CloudUpload
{
    /**
     * Uploads a new file to cloud instance.
     *
     * @return string
     */
    public function uploadToCloud(UploadedFile $file, $filename)
    {
        /** @var FilesystemManager $cloud */
        $cloud = Storage::cloud();
        $path = 'images/' . $filename;
        $cloud->put($path, file_get_contents($file));
        $url = $cloud->url($path);
        return $url;
    }
}

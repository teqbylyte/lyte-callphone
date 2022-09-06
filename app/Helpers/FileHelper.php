<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelper
{
    /**
     * Process the file uploaded by assigning a unique identifier and store in the specified directory argument.
     *
     * @param UploadedFile $file
     * @param string $name file name
     * @param string $dir directory to store file.
     *
     * @return bool|string false if the uploading failed or the path of the file if successful
     */
    public static function processFileUpload(UploadedFile $file , string $name, string $dir): bool|string
    {
        $name = str_replace(" ", "-", $name);

        //Process new file
        $base_name = $name . uniqid(rand()) . '.' . $file->getClientOriginalExtension();

        return Storage::disk('public')->putFileAs($dir, $file, $base_name);
    }
}

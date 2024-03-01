<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * @param Illuminate\Http\UploadedFile $file
     * @param string $directory directory where file is to be stored
     * @return string path to the file inside storage
     */
    public function upload(UploadedFile $file, $directory = 'uploads'): string
    {
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $fileName, 'public');
        return $path;
    }

    /**
     * @param string $path full path of file to be deleted
     * @return bool true if deleted, false if no file exists
     */
    public function delete($path): bool
    {
        if (file_exists($path)) {
            unlink(public_path() . '/' . $path);
            return true;
        } else {
            return false;
        }
    }
}

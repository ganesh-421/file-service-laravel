<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * @param string $directory directory where file is to be stored
     * @return string path to the file inside storage
     */
    public function upload($file, $directory = 'uploads'): string
    {

        if ($file instanceof UploadedFile) {
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($directory, $fileName, 'public');
            return $path;
        } else if (is_string($file)) {

            $imageBinary = base64_decode($file);

            $finfo = finfo_open();
            $mimeType = finfo_buffer($finfo, $imageBinary, FILEINFO_MIME_TYPE);
            finfo_close($finfo);
            $extension = explode('/', $mimeType)[1];
            $fileName = uniqid() . '_' . time() . '.' . $extension;
            $path = Storage::disk('public')->put($directory . '/' . $fileName, $imageBinary);
            if ($path)
                return $directory . '/' . $fileName;
            return false;
        }
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

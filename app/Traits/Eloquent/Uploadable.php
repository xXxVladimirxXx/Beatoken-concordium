<?php

namespace App\Traits\Eloquent;

use Illuminate\Support\Facades\Storage;

trait Uploadable
{
    public static function uploadPhoto($file, $filename, $folder = null, $rootFolder = 'photos/', $storage = 'public')
    {
        // save file to directory $storage/$rootFolder/$folder/$filename
        $path = Storage::disk($storage)->putFileAs($rootFolder . $folder, $file, $filename);

        if (Storage::disk($storage)->exists($path)) {
            return $path;
        }

        return null;
    }
}

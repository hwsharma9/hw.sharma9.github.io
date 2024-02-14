<?php

namespace App\Http\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait FileUpload
{
    public function UploadFile(UploadedFile $file, $folder = null, $filename = null, $disk = 'public')
    {
        $FileName = !is_null($filename) ? $filename : Str::random(10);
        return $file->storeAs(
            $folder,
            $FileName . "." . $file->getClientOriginalExtension(),
            $disk
        );
    }
}

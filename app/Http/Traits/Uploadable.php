<?php

namespace App\Http\Traits;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

trait Uploadable
{
    use FileUpload;

    public function uploadModelFile($model, $filename = null)
    {
        // info('uploadModelFile Upload file for ' . get_class($model));
        // Get model file path
        $folder = get_class($model);
        // Check if files uploaded
        if (request()->file()) {
            // Loop all file type inputs
            foreach (request()->file() as $file_input_name => $file) {
                // Check if file input is exists
                if (request()->hasFile($file_input_name)) {
                    // If file input has multiple attribute
                    // It means it will be an array
                    if (is_array(request()->file($file_input_name))) {
                        // Loop all files uploaded
                        foreach (request()->file($file_input_name) as $file) {
                            // Get path where file uploaded
                            $path = $this->UploadFile($file, $folder, $filename);
                            // If file path is not empty
                            if (!empty($path)) {
                                // Fetch upload relationship of model
                                // and save the upload related data into uploaded table.
                                $model->upload()->create([
                                    'folder' => $folder,
                                    'file_path' => $path,
                                    'original_name' => $file->getClientOriginalName(),
                                    'field_name' => $file_input_name,
                                ]);
                            }
                        }
                        // else input has single file uploaded
                    } else {
                        // Get path where file uploaded
                        $path = $this->UploadFile(request()->file($file_input_name), $folder, $filename);
                        // If file path is not empty
                        if (!empty($path)) {
                            // Fetch upload relationship of model
                            // and save the upload related data into uploaded table.
                            $model->upload()->create([
                                'folder' => $folder,
                                'file_path' => $path,
                                'original_name' => request()->file($file_input_name)->getClientOriginalName(),
                                'field_name' => $file_input_name,
                            ]);
                        }
                    }
                }
            }
        }
    }

    public function flushAndUpload()
    {
        if (request()->file()) {
            // Loop all file type inputs
            foreach (request()->file() as $file_input_name => $file) {
                if (request()->hasFile($file_input_name)) {
                    $image = $this->upload;
                    if ($image) {
                        // delete the old image from storage and database.
                        $image->delete();
                    }

                    $this->uploadModelFile($this);
                }
            }
        }
    }

    /**
     * Get single uploaded file.
     */
    public function upload()
    {
        return $this->morphOne(Upload::class, 'uploadable');
    }

    /**
     * Get multiple uploaded files.
     */
    public function uploads()
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }
}

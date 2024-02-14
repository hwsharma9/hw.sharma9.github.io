<?php

namespace App\Http\Traits;

use App\Models\Course;
use App\Models\CourseMedia;
use App\Models\CourseTopic;
use App\Models\CourseUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

trait CourseUploadable
{
    use FileUpload;

    public function uploadModelFile($model, $files, $file_input_name, $filename = null)
    {
        if ($files instanceof \Illuminate\Http\UploadedFile) {
            $this->uploadOneFile($model, $files, $file_input_name);
        } else {
            if ($files) {
                foreach ($files as $file_input_name => $file_array) {
                    foreach ($file_array as $file) {
                        if ($file instanceof \Illuminate\Http\UploadedFile) {
                            $this->uploadOneFile($model, $file, $file_input_name);
                        }
                        // $this->uploadModelFile($model, $file, $file_input_name);
                    }
                }
            }
        }
    }

    public function uploadOneFile($model, $file, $file_input_name, $filename = null)
    {
        $fk_course_id = '';
        if ($model instanceof Course) {
            $fk_course_id = $model->id;
        } elseif ($model instanceof CourseTopic) {
            $fk_course_id = $model->course->id;
        } elseif ($model instanceof CourseMedia) {
            if ($model->uploadable instanceof Course) {
                $fk_course_id = $model->id;
            } else {
                $fk_course_id = $model->course->id;
            }
        }
        $folder = get_class($model);
        // Get path where file uploaded
        $path = $this->UploadFile($file, $folder, $filename);
        // If file path is not empty
        if (!empty($path)) {
            // Fetch upload relationship of model
            // and save the upload related data into uploaded table.
            $model->upload()->create([
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'field_name' => $file_input_name,
                'file_mime_type' => $file->getMimeType(),
                'fk_course_id' => $fk_course_id,
            ]);
        }
    }

    /**
     * Get single uploaded file.
     */
    public function upload()
    {
        return $this->morphOne(CourseMedia::class, 'uploadable');
    }

    /**
     * Get multiple uploaded files.
     */
    public function uploads()
    {
        return $this->morphMany(CourseMedia::class, 'uploadable');
    }
}

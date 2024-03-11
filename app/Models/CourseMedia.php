<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\CourseLoggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CourseMedia extends Model
{
    use HasStatus;
    use Admined;
    use Encryptable;
    use CourseLoggable;
    use SoftDeletes;

    protected $table = 'tbl_course_media';

    protected $fillable = [
        'id',
        'uploadable_id',
        'uploadable_type',
        'file_mime_type',
        'file_path',
        'update_file_path',
        'original_name',
        'field_name',
        'fk_course_id',
        'course_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    private static $check_diff = [
        'file_path'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'preview',
    ];

    /**
     * Get the parent uploadable model (Admin, User or media).
     */
    public function uploadable()
    {
        return $this->morphTo();
    }

    public function checkCourseDiff($uploads, $type)
    {
        // echo "<pre>";
        // print_r($uploads);
        // echo "</pre>";
        $approved = clone $uploads;
        $new_upload = clone $uploads;

        $approved = ($uploads->where('course_status', 2)->toArray());
        $new_upload = ($uploads->where('course_status', '!=', 2)->toArray());
        // echo "<pre>";
        // print_r(json_encode(array_values($approved)));
        // print_r(json_encode(array_values($new_upload)));
        // echo "</pre>";
        $approved_path = '';
        $new_upload_path = '';
        $is_file = false;
        $mime_type = '';
        if ($type === 'course_thumbnail') {
            // $approved_path = $approved ? $approved->file_path : '';
            // $new_upload_path = $new_upload ? $new_upload->file_path : 'Image Deleted';
            $is_file = true;
        }
        return '<a href="javascript:void(0)" class="text-red content-changed"
            data-file="1"
         data-approved="' . htmlspecialchars(json_encode(array_values($approved)), ENT_QUOTES, 'UTF-8') . '"
         data-changed="' . htmlspecialchars(json_encode(array_values($new_upload)), ENT_QUOTES, 'UTF-8') . '">View Changes</a>';
    }

    public function checkCourseVideoDiff($column = 'file_path')
    {
        // echo '<pre>';
        // print_r($this);
        // print_r($column);
        // echo '</pre>';
        $update_column = 'update_' . $column;
        if (isset($this->$update_column)) {
            // echo $this->$column . '!=' . $this->$update_column;
            if ($this->$column != $this->$update_column) {
                return '<a href="javascript:void(0)" class="text-red content-changed"
                data-column="' . $column . '"
                data-approved="' . htmlspecialchars($this->$column, ENT_QUOTES, 'UTF-8') . '"
                data-changed="' . htmlspecialchars($this->$update_column, ENT_QUOTES, 'UTF-8') . '">View Changes</a>';
            }
        }
        return '';
        // $log = $video->logs()->where('course_status', 2)->latest()->first();
        // if ($log) {
        //     $log_data = collect(json_decode($log->current_data, true));
        //     // echo "<pre>";
        //     // print_r($log_data->get('file_path'));
        //     // print_r($video->file_path);
        //     // echo "</pre>";
        //     if (strcmp($log_data->get('file_path'), $video->file_path)) {
        //         return '<a href="javascript:void(0)" class="text-red content-changed" data-column="file_path" data-approved="' . htmlspecialchars(($log_data->get('file_path')), ENT_QUOTES, 'UTF-8') . '" data-changed="' . htmlspecialchars(($video->file_path), ENT_QUOTES, 'UTF-8') . '">View Changes</a>';
        //     }
        // } else {
        //     return '';
        // }
    }

    public function getCheckDiff()
    {
        return self::$check_diff;
    }

    public static function boot()
    {
        Log::info('updating the info from course media');
        self::updating(function ($model) {
            $original = $model->getOriginal();
            Log::info($original);
            Log::info($model);
            if ($model->field_name == 'course_video') {
                // Log::info('-------');
                if (self::$check_diff) {
                    foreach (self::$check_diff as $column) {
                        if ($model->course_status >= 2) {
                            if ($model->isDirty($column)) {
                                $update_column = 'update_' . $column;
                                if (Schema::hasColumn((new self())->getTable(), $update_column)) {
                                    $model->$update_column = $model->$column;
                                    $model->$column = $original[$column];
                                }
                            }
                        }
                    }
                }
            }
            // Log::info($original);
            // Log::info($model);
        });
        parent::boot();
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    protected static function booted(): void
    {
        // If uploaded file record deleted from any model
        static::forceDeleted(function ($upload) {
            // Delete file from storage folder too
            Storage::disk('public')->delete($upload->file_path);
        });
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function filePath(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                if ($this->file_mime_type != 'application/video') {
                    return asset('storage/' . str_replace('\\', '/', $value));
                } else {
                    return $value;
                }
            }
        );
        // get: fn ($value) => asset('storage/' . str_replace('\\', '/', $value))
    }

    public function preview(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->file_mime_type == 'image/jpeg') {
                    return 'image';
                } else if ($this->file_mime_type == 'application/pdf') {
                    return 'pdf';
                }
            },
        );
    }
}

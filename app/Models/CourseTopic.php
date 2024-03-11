<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\CourseUploadable;
use App\Http\Traits\Encryptable;
use App\Http\Traits\CourseLoggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;

class CourseTopic extends Model
{
    use HasFactory;
    use Admined;
    use CourseUploadable;
    use Encryptable;
    use CourseLoggable;

    protected $table = 'tbl_course_topics';

    protected $fillable = [
        'id',
        'fk_course_id',
        'title',
        'update_title',
        'summary',
        'update_summary',
        'status',
        'is_edited',
        'course_status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    private static $check_diff = [
        'id',
        'fk_course_id',
        'title',
        'summary',
    ];

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

    /**
     * Get the course that owns the CourseTopic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'fk_course_id', 'id');
    }

    public function getCheckDiff()
    {
        return self::$check_diff;
    }

    public function checkDiff($column = null)
    {
        // echo "<pre>";
        // print_r($this->only('title', 'update_title', 'summary', 'update_summary'));
        // print_r($column);
        // echo "</pre>";
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
        // $log_data = collect(json_decode($log->current_data, true))->only($this->check_diff);
        // $this_data = collect($this->toArray())->only($this->check_diff);
        // if ($column) {
        //     if (strcmp($log_data->get($column), $this_data->get($column))) {
        //         return '<a href="javascript:void(0)" class="text-red content-changed" data-column="' . $column . '" data-approved="' . htmlspecialchars(($log_data->get($column)), ENT_QUOTES, 'UTF-8') . '" data-changed="' . htmlspecialchars(($this_data->get($column)), ENT_QUOTES, 'UTF-8') . '">View Changes</a>';
        //     }
        // }
        // return '';
    }

    public static function boot()
    {
        self::updating(function ($model) {
            // Log::info('updating the info from course model');
            $original = $model->getOriginal();
            // Log::info($original);
            // Log::info($model);
            // Log::info('-------');
            if (self::$check_diff) {
                foreach (self::$check_diff as $column) {
                    if ($model->course_status >= 2) {
                        if ($model->isDirty($column)) {
                            $update_column = 'update_' . $column;
                            if (Schema::hasColumn('tbl_course_topics', $update_column)) {
                                $model->$update_column = $model->$column;
                                $model->$column = $original[$column];
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
}

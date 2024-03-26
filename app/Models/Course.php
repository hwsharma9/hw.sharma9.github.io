<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\CourseUploadable;
use App\Http\Traits\Encryptable;
use App\Http\Traits\CourseLoggable;
use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class Course extends Model
{
    use HasFactory;
    use Admined;
    use CourseLoggable;
    use Encryptable;
    use CourseUploadable;
    use HasStatus;

    protected $table = 'tbl_courses';

    protected $fillable = [
        'id',
        'fk_m_admin_course_id',
        'description',
        'update_description',
        'course_status',
        'status',
        'is_edited',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    private static $check_diff = [
        'id',
        'description',
    ];

    /**
     * Get the assignedAdmin that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(MAdminCourse::class, 'fk_m_admin_course_id', 'id');
    }

    /**
     * Get the courseCategory that owns the MCourseCategoryCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseCategory(): BelongsTo
    {
        return $this->belongsTo(MCourseCategory::class, 'fk_course_category_id', 'id');
    }

    /**
     * Get all of the topics for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics(): HasMany
    {
        return $this->hasMany(CourseTopic::class, 'fk_course_id', 'id');
    }

    /**
     * Get all of the topicsUploads for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function topicsUploads(): HasManyThrough
    {
        return $this->hasManyThrough(CourseMedia::class, CourseTopic::class, 'fk_course_id', 'uploadable_id', 'id', 'id');
    }

    public function getTopicUploads()
    {
        return $this->topics()->has('uploads')->with(['uploads']);
    }

    /**
     * Get all of the requests for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests(): HasMany
    {
        return $this->hasMany(CourseApprovalRequest::class, 'fk_course_id', 'id');
    }

    public function getCheckDiff()
    {
        return self::$check_diff;
    }

    /**
     * Get all of the enrollments for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class, 'fk_course_id', 'id');
    }

    public function checkDiff($column = null)
    {
        // echo "<pre>";
        // print_r($this->only('description', 'update_description'));
        // print_r($column);
        // echo "</pre>";
        $update_column = 'update_' . $column;
        if (isset($this->$update_column)) {
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

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        // print_r($filter);
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['category']) && !empty($filter['category'])), function ($query) use ($filter) {
                $query->whereHas('assignedAdmin', function ($query)  use ($filter) {
                    $query->where('fk_course_category_id', 'like', '%' . $filter['category'] . '%');
                });
            })
                ->when((isset($filter['course_category_courses_id']) && !empty($filter['course_category_courses_id'])), function ($query) use ($filter) {
                    $query->whereHas('assignedAdmin', function ($query)  use ($filter) {
                        $query->where('fk_course_category_courses_id', 'like', '%' . $filter['course_category_courses_id'] . '%');
                    });
                })
                ->when((isset($filter['content_manager']) && !empty($filter['content_manager'])), function ($query) use ($filter) {
                    $query->whereHas('assignedAdmin', function ($query)  use ($filter) {
                        $query->where('fk_admin_id', 'like', '%' . $filter['content_manager'] . '%');
                    });
                })
                ->when((isset($filter['course_status'])), function ($query) use ($filter) {
                    $query->where('course_status', $filter['course_status']);
                })
                ->when((isset($filter['department']) && !empty($filter['department'])), function ($query) use ($filter) {
                    $query->whereHas('assignedAdmin', function ($query) use ($filter) {
                        $query->whereHas('courseCategory', function ($query) use ($filter) {
                            $department_id = strlen($filter['department']) > 150 ? decrypt($filter['department']) : $filter['department'];
                            $query->where('fk_department_id', $department_id);
                        });
                    });
                })
                ->when((isset($filter['course_name']) && !empty($filter['course_name'])), function ($query) use ($filter) {
                    $query->whereHas('assignedAdmin', function ($query) use ($filter) {
                        $query->whereHas('categoryCourse', function ($query) use ($filter) {
                            $query->where('course_name_en', 'like', '%' . $filter['course_name'] . '%');
                        });
                    });
                });
        });
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
                        // Log::info($column . ' isDirty => ' . $model->isDirty($column));
                        if ($model->isDirty($column)) {
                            $update_column = 'update_' . $column;
                            if (Schema::hasColumn('tbl_courses', $update_column)) {
                                // update_description = description
                                $model->$update_column = $model->$column;
                                // description = original description
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

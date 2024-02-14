<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class MCourseCategoryCourse extends Model
{
    use Admined;
    use Loggable;
    use Encryptable;
    use HasStatus;

    protected $table = 'm_course_category_courses';

    protected $fillable = [
        'fk_course_category_id',
        'course_name_hi',
        'course_name_en',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

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
     * Get the course associated with the MCourseCategoryCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function course(): HasOneThrough
    {
        return $this->HasOneThrough(Course::class, MAdminCourse::class, 'fk_course_category_courses_id', 'fk_m_admin_course_id');
    }

    /**
     * Get the configuration associated with the MCourseCategoryCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function configuration(): HasOne
    {
        return $this->hasOne(CourseConfiguration::class, 'fk_course_category_courses_id', 'id');
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['course_name']) && !empty($filter['course_name'])), function ($query) use ($filter) {
                $query->where('course_name_hi', 'like', '%' . $filter['course_name'] . '%')
                    ->orWhere('course_name_en', 'like', '%' . $filter['course_name'] . '%');
            })
                ->when((isset($filter['course_category']) && !empty($filter['course_category'])), function ($query) use ($filter) {
                    $query->where('fk_course_category_id', $filter['course_category']);
                })
                ->when((isset($filter['status'])), function ($query) use ($filter) {
                    $query->where('status', $filter['status']);
                });
        });
    }
}

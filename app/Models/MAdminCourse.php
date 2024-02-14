<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MAdminCourse extends Model
{
    use Admined;
    use HasStatus;
    use Loggable;
    use Encryptable;

    protected $fillable = [
        'fk_admin_id',
        'fk_course_category_id',
        'fk_course_category_courses_id',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the admin that owns the MAdminCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'fk_admin_id', 'id');
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
     * Get the categoryCourse that owns the MAdminCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryCourse(): BelongsTo
    {
        return $this->belongsTo(MCourseCategoryCourse::class, 'fk_course_category_courses_id', 'id');
    }

    /**
     * Get the course associated with the MAdminCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function courseContent(): HasOne
    {
        return $this->hasOne(Course::class, 'fk_m_admin_course_id', 'id');
    }

    /**
     * Get the configuration associated with the MCourseCategoryCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function configuration(): HasOne
    {
        return $this->hasOne(CourseConfiguration::class, 'fk_course_category_courses_id', 'fk_course_category_courses_id');
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query
                ->when((isset($filter['course_category_id']) && !empty($filter['course_category_id'])), function ($query) use ($filter) {
                    $query->where('fk_course_category_id', $filter['course_category_id']);
                })
                ->when((isset($filter['course_category_courses_id']) && !empty($filter['course_category_courses_id'])), function ($query) use ($filter) {
                    $query->where('fk_course_category_courses_id', $filter['course_category_courses_id']);
                })
                ->when((isset($filter['status'])), function ($query) use ($filter) {
                    $query->where('status', $filter['status']);
                });
        });
    }
}

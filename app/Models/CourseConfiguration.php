<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseConfiguration extends Model
{
    use Admined;
    use Encryptable;
    use Loggable;
    use HasStatus;

    protected $table = 'tbl_course_configurations';
    protected $fillable = [
        'fk_course_category_id',
        'fk_course_category_courses_id',
        'is_upload_pdf',
        'is_upload_video',
        'is_upload_ppt',
        'is_upload_doc',
        'is_upload_pdf_required',
        'is_upload_video_required',
        'is_upload_ppt_required',
        'is_upload_doc_required',
        'is_enrolment_required',
        'is_visible',
        'active_from',
        'active_to',
        'is_active',
        'is_downloadable',
        'is_course_completion_trackable',
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
     * Get the categoryCourse that owns the MAdminCourse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryCourse(): BelongsTo
    {
        return $this->belongsTo(MCourseCategoryCourse::class, 'fk_course_category_courses_id', 'id');
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['course_category_id']) && !empty($filter['course_category_id'])), function ($query) use ($filter) {
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

<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MCourseCategory extends Model
{
    use HasFactory;
    use Admined;
    use Loggable;
    use Encryptable;
    use HasStatus;

    protected $fillable = [
        'fk_department_id',
        'category_name_hi',
        'category_name_en',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the department that owns the MCourseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(MDepartment::class, 'fk_department_id', 'id');
    }

    /**
     * Get all of the courses for the MCourseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(MCourseCategoryCourse::class, 'fk_course_category_id', 'id');
    }

    /**
     * Get all of the courses for the MCourseCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoryCourses(): HasMany
    {
        return $this->hasMany(MCourseCategoryCourse::class, 'fk_course_category_id', 'id');
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['category_name']) && !empty($filter['category_name'])), function ($query) use ($filter) {
                $query->where('category_name_hi', 'like', '%' . $filter['category_name'] . '%')
                    ->orWhere('category_name_en', 'like', '%' . $filter['category_name'] . '%');
            })
                ->when((isset($filter['department']) && !empty($filter['department'])), function ($query) use ($filter) {
                    $query->where('fk_department_id', 'like', '%' . $filter['department'] . '%');
                })
                ->when((isset($filter['status'])), function ($query) use ($filter) {
                    $query->where('status', $filter['status']);
                });
        });
    }
}

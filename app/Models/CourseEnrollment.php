<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Observers\CourseEnrollmentObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseEnrollment extends Model
{
    use HasFactory;
    use Admined;

    protected $table = 'tbl_course_enrolments';

    protected $fillable = [
        'id',
        'fk_course_id',
        'fk_user_id',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the course that owns the CourseEnrollment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'fk_course_id', 'id');
    }

    /**
     * Get the user that owns the CourseEnrollment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fk_user_id', 'id');
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        CourseEnrollment::observe(CourseEnrollmentObserver::class);
    }
}

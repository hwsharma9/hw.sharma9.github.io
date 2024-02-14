<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseApprovalRequest extends Model
{
    use Admined;
    use Encryptable;
    use HasStatus;

    protected $table = 'tbl_course_approval_requests';

    protected $fillable = [
        'fk_course_id',
        'remark',
        'status',
        'topic_ids',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the course that owns the CourseRemark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'fk_course_id', 'id');
    }

    /**
     * Get the requestNotification that owns the CourseApprovalRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestNotification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'fk_notification_id', 'id');
    }
}

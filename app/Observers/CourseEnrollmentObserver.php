<?php

namespace App\Observers;

use App\Models\CourseEnrollment;
use App\Notifications\Admin\RequestToApproveCourseEnrollment;
use Illuminate\Support\Facades\Log;

class CourseEnrollmentObserver
{
    /**
     * Handle the CourseEnrollment "created" event.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return void
     */
    public function created(CourseEnrollment $courseEnrollment)
    {
        if ($courseEnrollment->status == 0) {
            Log::info('Send Notification to enrollment');
            $courseEnrollment->course->creator->creator->notify(new RequestToApproveCourseEnrollment($courseEnrollment));
        }
    }

    /**
     * Handle the CourseEnrollment "updated" event.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return void
     */
    public function updated(CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Handle the CourseEnrollment "deleted" event.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return void
     */
    public function deleted(CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Handle the CourseEnrollment "restored" event.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return void
     */
    public function restored(CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Handle the CourseEnrollment "force deleted" event.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return void
     */
    public function forceDeleted(CourseEnrollment $courseEnrollment)
    {
        //
    }
}

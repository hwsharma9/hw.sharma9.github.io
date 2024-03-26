<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;

class CourseEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course, CourseEnrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course, CourseEnrollment $enrollment)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Course $course, CourseEnrollment $enrollment)
    {
        $configuration = $course?->assignedAdmin?->categoryCourse?->configuration;
        $enrollment = $course->enrollments()->firstOrCreate([
            'fk_user_id' => auth('sanctum')->user()->id,
        ], [
            'status' => ($configuration?->is_enrolment_required == 1) ? 0 : 1,
        ]);

        $message = ($configuration?->is_enrolment_required == 1) ? 'Enrolment request sent' : 'Enrolled successfully';

        return response()->json([
            'status' => 200,
            'data' => [
                'enrollment' => $enrollment
            ],
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course, CourseEnrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course, CourseEnrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course, CourseEnrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, CourseEnrollment $enrollment)
    {
        //
    }
}

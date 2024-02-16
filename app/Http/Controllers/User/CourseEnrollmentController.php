<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CourseEnrollment;
use App\Models\ErrorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enrolled_courses =
            CourseEnrollment::with([
                'course:id,description',
                'user:id,username,first_name,last_name'
            ])->get();

        return $enrolled_courses;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'course_id' => 'required|exists:courses,id',
                'status' => 'required|in:pending,confirmed,cancelled'
            ]
        );

        if ($validator->fails()) {
            return [
                "message" => "The given data was invalid.",
                'errors' => view(
                    'components.auth-validation-errors',
                    [
                        'errors' => $validator->errors()
                    ]
                )->render(),
            ];
        }

        DB::beginTransaction();
        try {
            $validated = $validator->validated();
            // Create a new CourseEnrollment instance and fill it with the request data
            $enrollment = new CourseEnrollment($validated);

            // Save the enrollment to the database
            $enrollment->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            Log::info($th);
            ErrorLog::create([
                'class_name' => get_class(),
                'function_name' => __FUNCTION__,
                'error' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'error' => __('app.went_wrong'),
            ];
        }

        // Return a success response or redirect to another page
        return response()->json([
            'message' => 'You have Enrolled for this course successfully',
            'enrollment' => $enrollment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return \Illuminate\Http\Response
     */
    public function show(CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseEnrollment $courseEnrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseEnrollment  $courseEnrollment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseEnrollment $courseEnrollment)
    {
        //
    }
}

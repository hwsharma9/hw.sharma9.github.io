<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = [];
        if (!request()->has('filter')) {
            $filter['filter'] = request()->all();
        }
        request()->request->add($filter);
        // return request()->all();
        DB::enableQueryLog();
        $courses = Course::with([
            'upload',
            'assignedAdmin' => function ($query) {
                $query->select('id', 'fk_course_category_id', 'fk_course_category_courses_id')
                    ->with([
                        'courseCategory:id,fk_department_id,category_name_hi,category_name_en',
                        'categoryCourse:id,course_name_hi,course_name_en'
                    ]);
            },
            'topics.uploads'
        ])
            ->filter()
            // ->where('course_status', 4)
            ->latest()
            ->paginate(9)
            ->withQueryString();
        $query = DB::getQueryLog();
        // $departments = MDepartment::select(['id', 'title_en'])->latest('id')->get();
        return response()->json([
            'status' => 200,
            'data' => [
                'courses' => $courses,
                // 'departments' => $departments,
                // 'query' => $query,
                // 'post' => request()->all(),
            ]
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->load([
            'upload',
            'assignedAdmin' => function ($query) {
                $query->select('id', 'fk_course_category_id', 'fk_course_category_courses_id')
                    ->with([
                        'courseCategory:id,fk_department_id,category_name_hi,category_name_en',
                        'categoryCourse:id,course_name_hi,course_name_en'
                    ]);
            },
            'topics.uploads'
        ])->loadCount(['uploads', 'topicsUploads']);
        return response()->json([
            'status' => 200,
            'data' => [
                'course' => $course,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
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
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}

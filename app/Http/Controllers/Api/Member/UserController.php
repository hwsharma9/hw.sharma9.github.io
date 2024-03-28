<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\MCourseCategory;
use App\Models\MCourseCategoryCourse;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userCourses()
    {
        $my_courses = Course::query()
            ->with([
                'enrollments' => function ($query) {
                    $query->where('fk_user_id', auth()->user()->id);
                },
                'assignedAdmin' => function ($query) {
                    $query->select('id', 'fk_course_category_id', 'fk_course_category_courses_id')
                        ->with([
                            'courseCategory:id,fk_department_id,category_name_hi,category_name_en',
                            'categoryCourse:id,course_name_hi,course_name_en'
                        ]);
                },
            ])
            ->whereHas('enrollments', function ($query) {
                $query->where('fk_user_id', auth()->user()->id);
            })->get();
        // $my_courses1 = MCourseCategoryCourse::query()
        //     ->with(['course'])
        //     ->whereHas('course', function ($query) {
        //         $query->whereHas('enrollments', function ($query) {
        //             $query->where('fk_user_id', auth()->user()->id);
        //         });
        //     })
        //     ->get();
        $my_courses1 = MCourseCategory::query()
            ->with(['categoryCourses' => function ($query) {
                $query->with(['assignedAdmin' => function ($query) {
                    $query->with(['courseContent' => function ($query) {
                        $query->with(['enrollments' => function ($query) {
                            $query->where('fk_user_id', auth()->user()->id);
                        }]);
                    }]);
                }]);
            }])
            ->whereHas('categoryCourses', function ($query) {
                $query->whereHas('assignedAdmin', function ($query) {
                    $query->whereHas('courseContent', function ($query) {
                        $query->whereHas('enrollments', function ($query) {
                            $query->where('fk_user_id', auth()->user()->id);
                        });
                    });
                });
            })
            ->get();
        return response()->json([
            'status' => 200,
            'data' => [
                'my_courses' => $my_courses,
                'my_courses1' => $my_courses1,
            ],
        ]);
    }
}

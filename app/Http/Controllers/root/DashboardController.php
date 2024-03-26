<?php

namespace App\Http\Controllers\root;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\OfficeOnboarding;
use App\Models\Page;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::where('is_default', 1)
            ->where('status', 1)
            ->firstOrFail();
        $sliders = Slider::active()->get();
        $courses = Course::with([
            'upload',
            'assignedAdmin' => function ($query) {
                $query->select('id', 'fk_course_category_courses_id')
                    ->with(['categoryCourse:id,course_name_hi,course_name_en']);
            }
        ])
            ->where('course_status', 3)
            ->latest()
            ->take(10)
            ->get();

        $registered_users = User::count();
        $courses_enrolled = Course::count();
        $department_onboarded_count = OfficeOnboarding::count();
        return view('root.index', compact(
            'page',
            'sliders',
            'courses',
            'registered_users',
            'courses_enrolled',
            'department_onboarded_count',
        ));
    }
}

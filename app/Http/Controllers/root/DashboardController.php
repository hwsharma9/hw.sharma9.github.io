<?php

namespace App\Http\Controllers\root;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Page;
use App\Models\Slider;
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
                $query->select('id', 'fk_course_category_courses_id')->with(['categoryCourse:id,course_name_hi,course_name_en']);
            }
        ])
            ->where('course_status', 4)
            ->latest()
            ->take(10)
            ->get();
        return view('root.index', compact('page', 'sliders', 'courses'));
    }
}

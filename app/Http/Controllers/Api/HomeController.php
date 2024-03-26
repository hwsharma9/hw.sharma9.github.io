<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\MenuTree;
use App\Models\Course;
use App\Models\FrontMenu;
use App\Models\OfficeOnboarding;
use App\Models\Page;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $registered_users = User::count();
        $courses_enrolled = Course::active()->count();
        $department_onboarded = OfficeOnboarding::with(['office'])
            ->has('office')
            ->active()
            ->latest()
            ->take(8)
            ->get();
        $sliders = Slider::select([
            'id',
            'title_hi',
            'title_en',
            'fk_slider_category_id',
            'fk_controller_route_id',
            'fk_page_id',
            'custom_url',
            'menu_type'
        ])
            ->active()
            ->with(['upload'])
            ->get();
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
        $page = Page::where('is_default', 1)
            ->where('status', 1)
            ->firstOrFail();
        return response()->json([
            'status' => 200,
            'data' => [
                'registered_users' => $registered_users,
                'courses_enrolled' => $courses_enrolled,
                'department_onboarded' => $department_onboarded->pluck('office'),
                'department_onboarded_count' => $department_onboarded->count(),
                'sliders' => $sliders,
                'courses' => $courses,
                'page' => $page,
            ]
        ]);
    }

    public function app()
    {
        $top_menus = FrontMenu::orderBy('menu_order', 'asc')
            ->with(['frontMenuType', 'page', 'dbControllerRoute'])
            ->location(1)
            ->get();
        $top_menus_tree = MenuTree::tree($top_menus, 0);
        $bottom_menus = FrontMenu::orderBy('menu_order', 'asc')
            ->with(['frontMenuType', 'page', 'dbControllerRoute'])
            ->location(2)
            ->get();
        $bottom_menus_tree = MenuTree::tree($bottom_menus, 0);
        $footer_slider = FrontMenu::orderBy('menu_order', 'asc')
            ->with(['frontMenuType', 'page', 'dbControllerRoute'])
            ->location(1)
            ->get();
        $footer_slider_tree = MenuTree::tree($footer_slider, 2);
        return [
            'status' => 200,
            'data' => [
                'top_menus' => $top_menus_tree,
                'bottom_menus' => $bottom_menus_tree,
                'footer_slider' => $footer_slider_tree,
            ]
        ];
    }
}

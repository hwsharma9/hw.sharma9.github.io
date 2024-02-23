<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\MenuTree;
use App\Models\Course;
use App\Models\FrontMenu;
use App\Models\OfficeOnboarding;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $registered_users = User::count();
        $courses_enrolled = Course::active()->count();
        $department_onboarded = OfficeOnboarding::with(['department'])->active()->get();
        return [
            'status' => 200,
            'data' => [
                'registered_users' => $registered_users,
                'courses_enrolled' => $courses_enrolled,
                'department_onboarded' => $department_onboarded->pluck('department'),
                'department_onboarded_count' => $department_onboarded->count(),
            ]
        ];
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

<?php

namespace App\View\Components\Admin\Dashboard;

use App\Models\Admin;
use App\Models\Course;
use App\Models\OfficeOnboarding;
use App\Models\User;
use Illuminate\View\Component;

class SuperAdminDashboard extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $department_users = Admin::count();
        $application_users = User::count();
        $offices = OfficeOnboarding::count();
        $courses = Course::count();
        return view('components.admin.dashboard.super-admin-dashboard', compact(
            'department_users',
            'application_users',
            'offices',
            'courses'
        ));
    }
}

<?php

namespace App\View\Components;

use App\Models\AdminRole;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $admin_roles = AdminRole::query()
            // ->without(['role'])
            ->where('fk_user_id', auth('admin')->id())
            ->where(function ($query) {
                $query->where('to_date', null)
                    ->orWhereDate('to_date', '>=', now());
            })
            ->active()
            ->get();
        // echo "<pre>";
        // print_r($unread_notifications->toArray());
        // echo "</pre>";
        // die;
        // $admin_roles = auth('admin')->user()->admin_roles()->where('status', 1)->get();
        return view('layouts.admin', compact('admin_roles'));
    }
}

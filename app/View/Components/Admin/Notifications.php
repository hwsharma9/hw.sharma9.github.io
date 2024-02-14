<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notifications extends Component
{
    public $unread_notifications;
    public $group_notifications;
    public $notifications_html = [];
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->unread_notifications = auth()->user()
            ->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->get();
        $this->group_notifications = $this->groupNotifications();

        // echo "<pre>";
        // print_r($this->notifications_html);
        // echo "</pre>";
        // dd('wait');
    }

    public function groupNotifications()
    {
        $this->group_notifications = $this->unread_notifications->groupBy('type');
        $notifications_html = [];
        if ($this->group_notifications) {
            foreach ($this->group_notifications as $key => $group_notification) {
                if ($key === 'App\Notifications\Admin\RequestToApproveCourse') {
                    // dd($this->group_notifications);
                    // echo "<pre>";
                    // print_r($group_notification->groupBy('data.request_status'));
                    // echo "</pre>";
                    $group_data_by_status_lists = $group_notification->groupBy('data.request_status');
                    if ($group_data_by_status_lists) {
                        foreach ($group_data_by_status_lists as $status_key => $group_data_by_status_list) {
                            $message = '';
                            $url = '#';
                            $time = $group_data_by_status_list->first()->created_at->diffForHumans();
                            // print_r($group_data_by_status_list->first());
                            // $group_data_by_status_list->first()->created_at->diffForHumans();
                            if ($status_key == 0) {
                                $message = $group_data_by_status_list->count() . ' Request for Approval.';
                                $url = route('manage.courses.index');
                            } else if ($status_key == 1) {
                                $message = $group_data_by_status_list->count() . ' Send for Correction.';
                                $url = route('manage.assigned_courses.index');
                            } else {
                                $message = $group_data_by_status_list->count() . ' Request Approve.';
                                $url = route('manage.assigned_courses.index');
                            }
                            $notifications_html[] = '<a href="' . $url . '" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> ' . $message . '
                                <span
                                        class="float-right text-muted text-sm">' . $time . '</span>
                            </a>';
                        }
                    }
                }
            }
        }
        $this->notifications_html = collect($notifications_html);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.notifications');
    }
}

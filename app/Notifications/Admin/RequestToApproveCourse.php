<?php

namespace App\Notifications\Admin;

use App\Models\CourseApprovalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestToApproveCourse extends Notification
{
    use Queueable;
    public $request;
    /**
     * Create a new notification instance.
     */
    public function __construct(CourseApprovalRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function getMessage()
    {
        if ($this->request->status == 0) {
            return "Request to approve sent from " . session('role_name');
        } else if ($this->request->status == 1) {
            return "Send For Correction sent from " . session('role_name');
        } else {
            return "Your Request is Approve by " . session('role_name');
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $this->request->fk_notification_id = $this->id;
        $this->request->saveQuietly();
        return [
            "message" => $this->getMessage(),
            "requested_by" => auth()->id(),
            "request_status" => $this->request->status,
        ];
    }
}

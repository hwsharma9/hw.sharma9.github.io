<?php

namespace App\Notifications\Admin;

use App\Models\CourseEnrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestToApproveCourseEnrollment extends Notification
{
    use Queueable;
    public $enrollment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CourseEnrollment $enrollment)
    {
        $this->enrollment = $enrollment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function getMessage()
    {
        return '<strong>' . $this->enrollment->user->first_name . '</strong> Requested to enroll the course <strong>' . $this->enrollment->course->assignedAdmin->categoryCourse->course_name_en . '</strong>';
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "message" => $this->getMessage(),
            "requested_by" => auth()->id(),
        ];
    }
}

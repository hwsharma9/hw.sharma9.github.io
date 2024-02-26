<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class CreateCourse extends Component
{
    public $course;
    public $alloted_admin;
    public $course_topics = [];

    public function mount(Course $course, $alloted_admin)
    {
        $this->course = $course;
        $this->alloted_admin = $alloted_admin;
        $this->course_topics = $course->topics;
    }

    public function render()
    {
        return view('livewire.create-course');
    }

    public function updateCourseMedia()
    {
        print_r($_FILES);
    }

    public function save()
    {
    }
}

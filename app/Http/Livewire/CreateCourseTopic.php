<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\CourseTopic;
use Livewire\Component;

class CreateCourseTopic extends Component
{
    public $course;
    public $alloted_admin;
    public $topic;
    public $configuration;
    public $parent_loop;

    public function mount(Course $course, $alloted_admin, $topic = null, $parent_loop = null)
    {
        $this->course = $course;
        $this->alloted_admin = $alloted_admin;
        $this->topic = $topic;
        $this->configuration = $course->configuration;
        $this->parent_loop = $parent_loop;
    }

    public function render()
    {
        if ($this->topic) {
            return view('livewire.create-course-topic');
        } else {
            return view('livewire.create-course-topic');
        }
    }
}

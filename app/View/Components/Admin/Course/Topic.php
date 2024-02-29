<?php

namespace App\View\Components\Admin\Course;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Topic extends Component
{
    public $configuration;
    public $topic;
    public $loop;

    /**
     * Create a new component instance.
     */
    public function __construct($configuration, $topic, $loop)
    {
        $this->configuration = $configuration;
        $this->topic = $topic;
        $this->loop = $loop;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.course.topic');
    }
}

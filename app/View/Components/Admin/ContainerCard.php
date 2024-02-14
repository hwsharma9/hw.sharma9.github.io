<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class ContainerCard extends Component
{
    public $title;
    public $showmessage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'ADD TITLE HERE', $showmessage = true)
    {
        $this->title = $title;
        $this->showmessage = $showmessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.container-card');
    }
}

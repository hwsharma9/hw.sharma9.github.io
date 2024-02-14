<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormActions extends Component
{
    public $actions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($actions)
    {
        $this->actions = $actions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.form-actions');
    }
}

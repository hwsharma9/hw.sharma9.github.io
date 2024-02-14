<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class StatusDropdown extends Component
{
    public $selected;
    public $isedit;
    public $required;
    public $search;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected = null, $required = true, $search = false)
    {
        $this->selected = is_null($selected) ? 0 : $selected;
        $this->isedit = is_null($selected);
        $this->required = $required;
        $this->search = $search;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.status-dropdown');
    }
}

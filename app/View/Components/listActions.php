<?php

namespace App\View\Components;

use Illuminate\View\Component;

class listActions extends Component
{
    public $actions;
    public $id;
    public $permissions;
    public $encrypt;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($actions, $id = '', $permissions = [], $encrypt = false)
    {
        $this->actions = $actions;
        $this->id = $id;
        $this->permissions = $permissions;
        $this->encrypt = $encrypt;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.list-actions');
    }
}

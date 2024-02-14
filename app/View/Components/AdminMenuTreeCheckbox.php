<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminMenuTreeCheckbox extends Component
{
    public $menus;
    public $role;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menus, $role)
    {
        $this->menus = $menus;
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-menu-tree-checkbox');
    }
}

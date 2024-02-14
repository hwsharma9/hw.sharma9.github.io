<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminMenuTree extends Component
{
    public $menus;
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menus, $class)
    {
        $this->menus = $menus;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin-menu-tree');
    }
}

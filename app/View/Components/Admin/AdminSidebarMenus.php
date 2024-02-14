<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class AdminSidebarMenus extends Component
{
    public $menus;
    public $first;
    public $range;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menus, $first, $range)
    {
        $this->menus = $menus;
        $this->first = $first;
        $this->range = $range;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.admin-sidebar-menus');
    }
}

<?php

namespace App\View\Components\Admin;

use App\Models\DbControllerRoute;
use App\Models\FrontMenuType;
use App\Models\Page;
use Illuminate\View\Component;

class DatetimeRangeSearchs extends Component
{
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = 'updated_at')
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.datetime-range-search');
    }
}

<?php

namespace App\View\Components\Admin;

use App\Models\DbControllerRoute;
use App\Models\FrontMenuType;
use App\Models\Page;
use Illuminate\View\Component;

class Linkable extends Component
{
    public $selectedMenutype;
    public $selectedCustomurl;
    public $selectedRoute;
    public $selectedPage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selectedMenutype = '', $selectedCustomurl = '', $selectedRoute = '', $selectedPage = '')
    {
        $this->selectedMenutype = $selectedMenutype;
        $this->selectedCustomurl = $selectedCustomurl;
        $this->selectedRoute = $selectedRoute;
        $this->selectedPage = $selectedPage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $front_menu_types = FrontMenuType::select(['id', 'title'])->get()->pluck('title', 'id')->all();
        $pages = Page::select(['id', 'slug'])->get()->pluck('slug', 'id')->all();
        $access_list = DbControllerRoute::select(['id', 'function_name', 'fk_controller_id'])
            ->whereHas('dbController', function ($query) {
                $query->where(['resides_at' => 'root', 'status' => '1']);
            })
            ->with(['dbController' => function ($query) {
                $query->select(['id', 'controller_name'])
                    ->where(['resides_at' => 'root', 'status' => '1']);
            }])
            ->where(['status' => 1])
            ->get()
            ->map(function ($route) {
                return [
                    'id' => $route->id,
                    'title' => $route->dbController->controller_name . '->' . $route->function_name
                ];
            })
            ->pluck('title', 'id')
            ->all();
        return view('components.admin.linkable', compact('front_menu_types', 'pages', 'access_list'));
    }
}

<?php

namespace App\View\Components\Front;

use App\Http\Services\MenuTree;
use App\Models\FrontMenu;
use Illuminate\View\Component;

class Menus extends Component
{
    public $menus;
    public $placedon;
    public $first;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menus = [], $placedon = 'Top Menus', $first = 1)
    {
        $this->menus = $menus;
        $this->placedon = $placedon;
        $this->first = $first;
    }

    public function getMenuCategory()
    {
        if ($this->placedon == 'Top Menus') {
            return 1;
        } elseif ($this->placedon == "Bottom Menus") {
            return 2;
        } else {
            return 3;
        }
    }
    public function getViewName()
    {
        if ($this->placedon == 'Top Menus') {
            return 'top-menus';
        } elseif ($this->placedon == "Bottom Menus") {
            return 'bottom-menus';
        } else {
            return 'side-menus';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // if front menus never passed, get them from db
        // and then pass them to view
        if (!count($this->menus)) {
            // get menus from FrontMenu model
            $menus_data = FrontMenu::with([
                'dbControllerRoute' => function ($query) {
                    $query->select('id', 'route', 'named_route');
                },
                'page' => function ($query) {
                    $query->select('id', 'title_en', 'title_hi', 'slug')
                        ->active();
                }
            ])
                ->where('fk_menu_type_id', $this->getMenuCategory())
                ->active()
                ->get();
            // Create tree of menus
            $this->menus = MenuTree::tree($menus_data, 0);
        }
        return view('components.front.' . $this->getViewName());
    }
}

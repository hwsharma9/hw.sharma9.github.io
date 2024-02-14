<?php

namespace App\View\Composers;

use App\Http\Services\MenuTree;
use App\Http\Services\RouteService;
use App\Models\AdminMenu;
use App\Repositories\UserRepository;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * The user repository implementation.
     *
     * @var \App\Repositories\UserRepository
     */
    protected $menus;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $route_service = new RouteService();
        $controller_route = $route_service->getControllerIdByRouteName();
        // Get all admin menus with it's permissions
        $menus_data = AdminMenu::without(['child'])
            ->with(['permission.dbControllerRoute.dbController'])
            ->orderBy('s_order', 'asc')
            ->get();
        // Create tree of menus
        $this->menus = MenuTree::tree($menus_data, 0, $controller_route);
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menus', $this->menus);
    }
}

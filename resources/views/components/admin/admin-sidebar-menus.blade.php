<ul
    @if ($first === 1) class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
    data-accordion="false" @else class="nav nav-treeview" @endif>
    @foreach ($menus as $menu)
        @php
            $li = [];
            $a = [];
            $children = isset($menu->children) ? $menu->children : (object) [];
            $c_collect = collect($children);
            // if($c_collect->count() && $first === 1) {
            //     $li[] = 'menu-open';
            //     // $li[] = '1';
            //     $a[] = 'active';
            // }
            if ($c_collect->count()) {
                $actions_db_route = $c_collect->pluck('permission.db_controller_route')->filter();
                $actions = array_unique(
                    $actions_db_route
                        ->map(function ($child) {
                            return $child->db_controller->resides_at . '/' . $child->route;
                        })
                        ->all(),
                );
                // if (in_array(request()->path(), $actions)) {
                //     $li[] = 'menu-open';
                // $li[] = '2';
                // $a[] = 'active';
                // }
                $children = implode(',', $actions);
            }

            $action = '';
            if (isset($menu->permission) && isset($menu->permission->db_controller_route) && isset($menu->permission->db_controller_route->route)) {
                $action = 'manage/' . $menu->permission->db_controller_route->route;
            }
            // if (request()->path() == $action) {
            //     $li[] = 'menu-open';
            //     // $li[] = '3';
            //     $a[] = 'active';
            // }
            $controller_name = '#';
            if (isset($menu->permission) && isset($menu->permission->db_controller_route) && isset($menu->permission->db_controller_route->db_controller->controller_name)) {
                $controller_name = $menu->permission->db_controller_route->db_controller->controller_name;
            }

            $route = route('manage.home');
            if (isset($menu->permission) && isset($menu->permission->db_controller_route) && isset($menu->permission->db_controller_route->route)) {
                $named_route = 'manage.' . $menu->permission->db_controller_route->named_route;
                $url = 'manage/' . $menu->permission->db_controller_route->route;
                if ($named_route && Route::has($named_route)) {
                    $params = is_null($menu->params) ? [] : json_decode($menu->params, true);
                    if (str_contains($menu->permission->db_controller_route->route, '}') && count($params) == 0) {
                        $route = url($url);
                    } else {
                        $route = route($named_route, $params);
                    }
                } else {
                    $route = url($url);
                }
            }
            if (isset($menu->selected) && $menu->selected == 1) {
                if ($menu->class_id == 'title') {
                    $li[] = 'menu-open';
                }
                if (!isset($menu->children) || $menu->class_id == '') {
                    $a[] = 'active';
                }
            }
            $li = implode(' ', array_unique($li));
            $a = implode(' ', array_unique($a));
        @endphp
        {{-- 
            Remove $auth_role->hasDirectPermission if want to show menu 
            after removed permission from "Assign User Access"
        --}}
        @if (in_array($menu->id, $range))
            @if (
                $controller_name == '#' ||
                    ($menu->fk_tbl_acl_permission_id && $auth_role->hasDirectPermission($menu->fk_tbl_acl_permission_id)))
                <li class="nav-item {{ $li }}">
                    <a href="{{ $route }}" class="nav-link {{ $a }}"
                        data1="{{ request()->path() . ' = ' . $action }}">
                        <i class="nav-icon {{ $menu->icon_class }}"></i>
                        <p>{{ $menu->menu_name }}
                            @if ($c_collect->count() > 0)
                                <i class="fas fa-angle-left right"></i>
                            @endif
                        </p>
                    </a>
                    @if ($c_collect->count() > 0)
                        <x-admin.admin-sidebar-menus :menus="$c_collect" :first="0" :range="$range" />
                    @endif
                </li>
            @endif
        @endif
    @endforeach
</ul>

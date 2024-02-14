<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Request;

class MenuTree
{
    /**
     * Create the tree of array
     *
     * @param $menus
     * @param $parent
     * @return string
     */
    public static function tree($menus = null, $parent = 0, $controller_route = null)
    {
        $menus_collection = clone $menus;
        $data = array();
        // Loop the menus array
        foreach ($menus_collection as $key => $menu) {
            // if menu id in data variables key not exists and parent id is equal to parent
            if (!array_key_exists($menu->id, $data) && $menu->parent_id == $parent) {
                $menu_array = $menu->toArray();
                $menu_array['selected'] = 0;
                if (!is_null($controller_route) && !is_null($menu_array['permission']) && !is_null($menu_array['permission']['db_controller_route'])) {
                    if (
                        (
                            $menu_array['permission']['db_controller_route']['fk_controller_id'] == $controller_route->fk_controller_id
                            || $menu_array['permission']['db_controller_route']['id'] == $controller_route->id
                        )
                        && self::isEqualToCurrentRoute($menu_array)
                    ) {
                        $menu_array['selected'] = 1;
                    }
                }
                // add menu to data
                $data[$menu_array['id']] = $menu_array;
                unset($menus[$key]);
            }

            // if menu parent_id in data variables key exists and parent id is equal to parent
            if (array_key_exists($menu->parent_id, $data) && $menu->parent_id != $parent) {
                // then put that menut into the children
                $child = self::tree($menus, $menu->parent_id, $controller_route);
                $child_ids = array_column(json_decode(json_encode($child), true), 'selected');
                // Check if the menu has selected child
                if (in_array(1, $child_ids)) {
                    $data[$menu->parent_id]['selected'] = 1;
                }
                if ($child) {
                    $data[$menu->parent_id]['children'] = $child;
                }
            }
        }
        // return the data with tree array
        return json_decode(json_encode($data));
    }

    public static function isEqualToCurrentRoute($menu_array)
    {
        $params = (isset($menu_array['params']) && !is_null($menu_array['params'])) ? json_decode($menu_array['params'], true) : [];
        if (count($params) == 0) {
            return true;
        }
        if (isset($menu_array['permission']) && isset($menu_array['permission']['db_controller_route']) && isset($menu_array['permission']['db_controller_route']['db_controller'])) {
            if (route($menu_array['permission']['db_controller_route']['db_controller']['resides_at'] . '.' . $menu_array['permission']['db_controller_route']['named_route'], $params) == Request::url()) {
                return true;
            }
        }
        return false;
    }
}

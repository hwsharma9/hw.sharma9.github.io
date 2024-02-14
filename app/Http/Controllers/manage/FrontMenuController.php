<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\MenuTree;
use App\Models\AdminMenu;
use App\Models\DbController;
use App\Models\DbControllerRoute;
use App\Models\FrontMenu;
use App\Models\FrontMenuType;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FrontMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = 'top')
    {
        $db_controller = DbController::whereHas('dbControllerRoute')
            ->with(['dbControllerRoute'])
            ->where('status', 1)
            ->where('resides_at', 'root')
            ->get();
        if ($type == 'Top Menus') {
            $type_id = 1;
            $title = "Top Menus";
        } elseif ($type == 'Bottom Menus') {
            $type_id = 2;
            $title = "Bottom Menus";
        } else {
            $type_id = 3;
            $title = "Side Menus";
        }
        $menus_data = FrontMenu::orderBy('menu_order', 'asc')
            ->location($type_id)
            ->get();
        $menus = MenuTree::tree($menus_data, 0);
        return view('admin.front_menus.index', compact('db_controller', 'menus', 'title', 'type_id', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'fk_menu_type_id' => 'required',
                'menu_type' => 'required',
                'fk_page_id' => ['required'],
                'icon_class' => 'nullable',
                'title_hi' => 'required',
                'title_en' => 'required',
                'open_same_tab' => 'required',
                'status' => 'required',
            ];
            $message = [
                'fk_menu_type_id.required' => 'Menu Location is Required',
                'menu_type.required' => 'Menu Type is Required',
                'title_hi.required' => 'Title in Hindi is Required',
                'title_en.required' => 'Title in English is Required',
                'open_same_tab.required' => 'Open on Same Tab is Required',
            ];
            if ($request->has('menu_type') && $request->menu_type == 1) {
                $message['fk_page_id.required'] = 'The Page is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 2) {
                $message['fk_page_id.required'] = 'The Module is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 3) {
                array_push($rules['fk_page_id'], 'url');
                $message['fk_page_id.required'] = 'The Custom URL is Required';
                $message['fk_page_id.url'] = 'The Custom URL Must be a valid URL. Ex:- http://www.example.com';
            }
            $validator = Validator::make(
                $request->all(),
                $rules,
                $message
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $validated = $validator->validated();
            if ($validated['menu_type'] == 1) {
                $page_route = DbControllerRoute::where([
                    'named_route' => 'page.show',
                    'method' => 'get',
                    'function_name' => 'show'
                ])->first();
                $validated['fk_controller_route_id'] = $page_route->id;
            } elseif ($validated['menu_type'] == 2) {
                $validated['fk_controller_route_id'] = $validated['fk_page_id'];
                $validated['fk_page_id'] = null;
            } elseif (in_array($validated['menu_type'], [3, 4])) {
                $validated['custom_url'] = $validated['fk_page_id'];
                $validated['fk_controller_route_id'] = null;
                $validated['fk_page_id'] = null;
            }
            // return $validated;
            FrontMenu::create($validated);
            $redirect = redirect();
            $redirect_url = '';
            $type = '';
            $redirect_url = 'manage.frontmenus.index';
            if ($request->get('fk_menu_type_id') == 1) {
                $type = 'Top Menus';
            } elseif ($request->get('fk_menu_type_id') == 2) {
                $type = 'Bottom Menus';
            } else {
                $type = 'Side Menus';
            }
            return (($request->has('action')) ? $redirect->back() : $redirect->route($redirect_url, $type))
                ->with('success', __('app.record_created'));
        }
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

        return view('admin.front_menus.create', compact('front_menu_types', 'pages', 'access_list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FrontMenu  $frontmenu
     * @return \Illuminate\Http\Response
     */
    public function show(FrontMenu $frontmenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FrontMenu  $frontmenu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, FrontMenu $frontmenu)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'menu_type' => 'required',
                'fk_page_id' => ['required'],
                'icon_class' => 'nullable',
                'title_hi' => 'required',
                'title_en' => 'required',
                'open_same_tab' => 'required',
                'status' => 'required',
            ];
            $message = [
                'menu_type.required' => 'Menu Type is Required',
                'title_hi.required' => 'Title in Hindi is Required',
                'title_en.required' => 'Title in English is Required',
                'open_same_tab.required' => 'Open on Same Tab is Required',
            ];
            if ($request->has('menu_type') && $request->menu_type == 1) {
                $message['fk_page_id.required'] = 'The Page is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 2) {
                $message['fk_page_id.required'] = 'The Module is Required';
            } elseif ($request->has('menu_type') && $request->menu_type == 3) {
                array_push($rules['fk_page_id'], 'url');
                $message['fk_page_id.required'] = 'The Custom URL is Required';
                $message['fk_page_id.url'] = 'The Custom URL Must be a valid URL. Ex:- http://www.example.com';
            }
            $validator = Validator::make(
                $request->all(),
                $rules,
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $validated = $validator->validated();
            if ($validated['menu_type'] == 1) {
                $page_route = DbControllerRoute::where([
                    'named_route' => 'page.show',
                    'method' => 'get',
                    'function_name' => 'show'
                ])->first();
                $validated['fk_controller_route_id'] = $page_route->id;
            } elseif ($validated['menu_type'] == 2) {
                $validated['fk_controller_route_id'] = $validated['fk_page_id'];
                $validated['fk_page_id'] = null;
            } elseif (in_array($validated['menu_type'], [3, 4])) {
                $validated['custom_url'] = $validated['fk_page_id'];
                $validated['fk_controller_route_id'] = null;
                $validated['fk_page_id'] = null;
            }
            // return $validated;
            $frontmenu->fill($validated);
            $frontmenu->save();

            $redirect = redirect();
            $redirect_url = '';
            $type = '';
            $redirect_url = 'manage.frontmenus.index';
            if ($request->get('fk_menu_type_id') == 1) {
                $type = 'Top Menus';
            } elseif ($request->get('fk_menu_type_id') == 2) {
                $type = 'Bottom Menus';
            } else {
                $type = 'Side Menus';
            }
            return (($request->has('action')) ? $redirect->back() : $redirect->route($redirect_url, $type))
                ->with('success', __('app.record_updated'));
        }
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

        return view('admin.front_menus.edit', compact(
            'frontmenu',
            'front_menu_types',
            'pages',
            'access_list'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FrontMenu  $frontmenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(FrontMenu $frontmenu)
    {
        $ids = $this->getChildNode($frontmenu->child->toArray(), $frontmenu->id);
        $ids = explode(',', $ids);
        FrontMenu::whereIn('id', $ids)->delete();
        $frontmenu->delete();
        return ['status' => true, 'message' => 'Front Menu deleted successfully.'];
    }

    public function getChildNode($list = array(), $parent_id = null, $parent_id_name = "parent_id", $id_name = "id")
    {
        $result = "";
        if ($parent_id != null) {
            foreach ($list as $cat) {
                if ($cat[$parent_id_name] == $parent_id) {
                    $current_id = $cat[$id_name];
                    $result .= "," . $current_id;
                    $result .= $this->getChildNode($list, $current_id, $parent_id_name, $id_name);
                }
            }
        }
        return trim($result, ',');
    }

    public function updateAll(Request $request)
    {
        $table_name = config('dbtables.table_names.front_menus');
        $array = parseJsonArray(json_decode($request->data));
        if ($this->menuUpdateAll($table_name, $array)) {
            return ['status' => true, 'message' => 'Front Menu ordered successfully.'];
        } else {
            return ['status' => true, 'message' => 'Nothing to update.'];
        }
    }

    public function menuUpdateAll($tbl = "", $readbleArray = array())
    {
        $ParentId = array();
        if (trim($tbl) != "" && count($readbleArray) > 0) {
            $i = 0;
            foreach ($readbleArray as $row) {
                $i++;
                if ($row['parentID'] == 0 && $row['id'] != 1) {
                    $ParentId[] = $row['id'];
                } else {
                    $ParentId[] = $row['parentID'];
                }
                DB::table($tbl)->where(['id' => $row['id']])->update(['parent_id' => $row['parentID'], 'menu_order' => $i]);
            } //end foreach loop

            $ParentId = array_unique($ParentId);
            DB::table($tbl)->where('id', '!=', 1)->update(['class_id' => null]);

            DB::table($tbl)->whereIn('id', $ParentId)->update(['class_id' => 'title']);
        } //end if
        return true;
    }
}

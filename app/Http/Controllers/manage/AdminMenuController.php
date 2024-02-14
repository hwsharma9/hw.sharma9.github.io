<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\MenuTree;
use App\Models\AdminMenu;
use App\Models\DbController;
use App\Models\DbControllerRoute;
use App\Models\Permission;
use App\View\Components\AdminMenuTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $db_controller = DbController::whereHas('dbControllerRoute', function ($query) {
            $query->where('function_name', 'index');
        })->with(['dbControllerRoute' => function ($query) {
            $query->with(['permission'])->where('function_name', 'index');
        }])
            ->where('status', 1)
            ->where('resides_at', 'manage')
            ->get();
        // return $db_controller;
        // $db_controller_routes = DbControllerRoute::whereHas('permission')->with(['permission', 'dbController'])->get();
        // dd($db_controller_routes);
        // $permissions = Permission::whControllerereHas('dbControllerRoute')->with(['dbControllerRoute'])->get();
        // dd($permissions->toArray());
        return view('admin.admin_menus.index', compact('db_controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $rules = [
            'menu_name' => 'required|min:2|max:40',
            'icon_class' => 'required|max:50', //|regex:[/^[a-zA-Z0-9\-\s]*$/]
            'fk_tbl_acl_permission_id' => 'nullable'
        ];
        $error_messages = [];
        if ($request->filled('params')) {
            foreach ($request->params as $key => $param) {
                $rules['params.' . $key] = 'required';
                $error_messages['params.' . $key . '.required'] = 'The ' . $key . ' field is required.';
            }
        }
        $validator = Validator::make($request->all(), $rules, $error_messages);

        if ($validator->fails()) {
            return [
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ];
        }
        $validated = $validator->validated();
        // return $validated;
        $validated['params'] = ($request->filled('params')) ? json_encode($request->params) : json_encode([]);
        $menu = AdminMenu::create($validated);
        // $menus = AdminMenu::where('parent_id', 0)->get();
        $menus_data = AdminMenu::without(['child'])
            ->with(['permission.dbControllerRoute.dbController'])
            ->orderBy('s_order', 'asc')
            ->get();
        $menus = MenuTree::tree($menus_data, 0);
        // $menus = json_decode(json_encode($menus));
        $html = view('components.admin.admin-menu-tree', ['menus' => $menus, 'class' => "dd-list"]);
        $html = $html->render();
        return ['message' => 'Menu Created successfully', 'status' => true, 'data' => $menu, 'html' => $html];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(AdminMenu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, AdminMenu $menu)
    {
        $rules = [
            'menu_name' => 'required',
            'icon_class' => 'required',
            'fk_tbl_acl_permission_id' => 'nullable',
            'params' => 'nullable',
        ];
        $error_messages = [];
        if ($request->filled('params')) {
            foreach ($request->params as $key => $param) {
                $rules['params.' . $key] = 'required';
                $error_messages['params.' . $key . '.required'] = 'The ' . $key . ' field is required.';
            }
        }
        $validator = Validator::make($request->all(), $rules, $error_messages);

        if ($validator->fails()) {
            return [
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ];
        }
        // return $request->params;
        $validated = $validator->validated();
        $validated['params'] = ($request->filled('params')) ? json_encode($request->params) : json_encode([]);
        $menu->fill($validated);
        $menu->save();
        $menus_data = AdminMenu::without(['child'])
            ->with(['permission.dbControllerRoute.dbController'])
            ->orderBy('s_order', 'asc')
            ->get();
        $menus = MenuTree::tree($menus_data, 0);
        // $menus = json_decode(json_encode($menus));

        $html = view('components.admin.admin-menu-tree', ['menus' => $menus, 'class' => "dd-list"]);
        $html = $html->render();
        return [
            'message' => 'Menu updated successfully',
            'status' => true,
            'data' => $menu->refresh(),
            'html' => $html
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminMenu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminMenu $menu)
    {
        $ids = $this->getChildNode($menu->child->toArray(), $menu->id);
        $ids = explode(',', $ids);
        AdminMenu::whereIn('id', $ids)->delete();
        $menu->delete();
        return ['status' => true, 'message' => 'Menu deleted successfully.'];
    }

    public function updateAll(Request $request)
    {
        $table_name = config('dbtables.table_names.admin_menus');
        $array = parseJsonArray(json_decode($request->data));
        if ($this->menuUpdateAll($table_name, $array)) {
            return ['status' => true, 'message' => 'Menu ordered successfully.'];
        } else {
            return ['status' => true, 'message' => 'Nothing to update.'];
        }
    }

    public function menuUpdateAll($tbl = "", $readbleArray = array())
    {

        // $this->db->trans_begin();

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
                DB::table($tbl)->where(['id' => $row['id']])->update(['parent_id' => $row['parentID'], 's_order' => $i]);
                // $this->db->update($tbl, array('parent_id' => $row['parentID'], 's_order' => $i), array('id' => $row['id']));
            } //end foreach loop

            $ParentId = array_unique($ParentId);
            DB::table($tbl)->where('id', '!=', 1)->update(['class_id' => null]);
            // $this->db->where(array('id!=' => 1));
            // $this->db->update($tbl, array('class_id' => NULL));

            DB::table($tbl)->whereIn('id', $ParentId)->update(['class_id' => 'title']);
            // $this->db->where_in('id', $ParentId);
            // $this->db->update($tbl, array('class_id' => 'title'));
            //print_r($this->db->last_query());

        } //end if
        return true;
        // if ($this->db->trans_status() === FALSE) {
        //     $this->db->trans_rollback();
        //     return FALSE;
        // } else {
        //     $this->db->trans_commit();
        //     return TRUE;
        // }
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
}

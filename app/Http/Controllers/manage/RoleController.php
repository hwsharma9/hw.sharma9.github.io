<?php

namespace App\Http\Controllers\manage;

use App\Models\DbController;
use App\Models\DbControllerRoute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Http\Services\JsonService;
use App\Models\AdminMenu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = Role::query()
                ->with([
                    'editor',
                    'creator',
                ]);
            $actions = [
                'edit' => 'manage.roles.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($actions, $permissions) {
                    $action = view('components.admin.list-actions', [
                        'actions' => $actions,
                        'model' => $row,
                        'permissions' => $permissions,
                        'encrypt' => true
                    ]);
                    $action = $action->render();

                    return $action;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));;
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->editColumn('editor_name', function ($row) {
                    return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:tbl_acl_roles',
                'description' => 'required',
                'range' => 'required',
                'used_for' => 'required',
                'captcha' => 'required|captcha',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            $validated['range'] = implode(',', $validated['range']);
            $role = Role::create($validated);

            // Creates Json for Sidebar Menus
            JsonService::createAdminSidebarMenuJson();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.roles.index'))
                ->with('success', __('app.record_created'));
        }
        $permission = Permission::get();
        $menus = AdminMenu::where('parent_id', 0)->get();
        $group_routes = DbController::with(['dbControllerRoute.permission'])->get();
        return view('admin.roles.create', compact('permission', 'menus', 'group_routes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role, Request $request)
    {
        if ($request->isMethod('post')) {
            $response = Gate::inspect('update', $role);
            if (!$response->allowed()) {
                return
                    redirect()->back()
                    ->withInput($request->input())
                    ->with('error', $response->message());
            }
            // return $request->all();
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
                'range' => 'required',
                'used_for' => 'required',
                'status' => 'required',
                'captcha' => 'required|captcha',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $validated = $validator->validated();
            $validated['range'] = implode(',', $validated['range']);
            $role->update($validated);

            // Creates Json for Sidebar Menus
            JsonService::createAdminSidebarMenuJson();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.roles.index'))
                ->with('success', __('app.record_updated'));
        }
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('manage.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}

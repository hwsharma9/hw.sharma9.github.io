<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\AssignUserAccess;
use App\Http\Requests\Admin\StoreAssignUserAccessRequest;
use App\Http\Requests\Admin\UpdateAssignUserAccessRequest;
use App\Http\Services\GateAllow;
use App\Http\Services\JsonService;
use App\Models\DbController;
use App\Models\DbControllerRoute;
use App\Models\ErrorLog;
use App\Models\Role;
use App\Models\View\AssignUserAccessView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AssignUserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = AssignUserAccessView::query()
                ->filter();
            $actions = [
                'edit' => 'manage.acl.edit',
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
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('editor_name', function ($row) {
                    return $row['editor_name'] ? $row['editor_name'] . ' (' . $row['editor_username'] . ')' : ($row['creator_name'] ? $row['creator_name'] . ' (' . $row['creator_username'] . ')' : '');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $roles = Role::backend()->get();
        $controllers = DbController::select(['id', 'title', 'controller_name'])->get();
        return view('admin.assign_user_access.index', compact('roles', 'controllers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'fk_role_id' => 'required',
                    'fk_controller_id' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'fk_role_id.required' => 'Role is required',
                    'fk_controller_id.required' => 'Controller is required',
                    'captcha.required' => 'Security Code is required.',
                ]
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();
            try {
                $assign_user_access = $request->only(['fk_role_id', 'fk_controller_id', 'status', 'created_by', 'updated_by']);
                $permissions = $request->function_name;
                AssignUserAccess::create($assign_user_access);
                $controller = DbControllerRoute::whereHas('permission')->with(['permission'])->where('fk_controller_id', $request->fk_controller_id)->get();
                $role = Role::with(['permissions' => function ($query) use ($controller) {
                    $query->whereIn('id', $controller->pluck('permission.id')->all());
                }])->find($request->fk_role_id);
                $all_permission = $role->permissions->pluck('id')->all();
                $add_permissions = array_diff($permissions, $all_permission);
                $remove_permissions = array_diff($all_permission, $permissions);
                if ($add_permissions) {
                    foreach ($add_permissions as $key => $add_permission) {
                        Role::find($request->fk_role_id)->givePermissionTo(intval($add_permission));
                    }
                }
                foreach ($remove_permissions as $key => $remove_permission) {
                    Role::find($request->fk_role_id)->revokePermissionTo(intval($remove_permission));
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->back()
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }

            // Creates Json for Sidebar Menus
            JsonService::createAdminSidebarMenuJson();
            // Creates Json for Role Permissions
            JsonService::createRolePermissionJson($role->refresh());

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.acl.index'))
                ->with('success', __('app.record_created'));
        }
        $roles = Role::backend()->get();
        $controllers = DbController::whereHas('dbControllerRoute', function ($query) {
            $query->whereHas('permission')->with(['permission']);
        })->with(['dbControllerRoute' => function ($query) {
            $query->whereHas('permission')->with(['permission']);
        }])->get();
        return view('admin.assign_user_access.create', compact('roles', 'controllers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignUserAccess  $assignUserAccess
     * @return \Illuminate\Http\Response
     */
    public function show(AssignUserAccess $assignUserAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignUserAccess  $assignUserAccess
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignUserAccess $acl, Request $request)
    {
        if ($request->isMethod('post')) {
            $response = Gate::inspect('update', $acl);
            if (!$response->allowed()) {
                return
                    redirect()->back()
                    ->withInput($request->input())
                    ->with('error', $response->message());
            }
            $validator = Validator::make(
                $request->all(),
                [
                    'status' => 'required',
                    // 'captcha' => 'required|captcha',
                ],
                [
                    'captcha.required' => 'Security Code is required.',
                ]
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            DB::beginTransaction();
            try {
                // Set the status of Assign User Access
                $acl->status = $request->status;
                $acl->save();

                $permissions = $request->function_name ?? [];
                $controller = DbControllerRoute::whereHas('permission')
                    ->with(['permission'])
                    ->where('fk_controller_id', $acl->fk_controller_id)
                    ->get();
                $role = Role::with(['permissions' => function ($query) use ($controller) {
                    $query->whereIn('id', $controller->pluck('permission.id')->all());
                }])->find($acl->fk_role_id);
                $all_permission = $role->permissions->pluck('id')->all();

                $add_permissions = array_diff($permissions, $all_permission);
                $remove_permissions = array_diff($all_permission, $permissions);
                if ($add_permissions) {
                    foreach ($add_permissions as $key => $add_permission) {
                        Role::find($acl->fk_role_id)->givePermissionTo(intval($add_permission));
                    }
                }
                if ($remove_permissions) {
                    foreach ($remove_permissions as $key => $remove_permission) {
                        Role::find($acl->fk_role_id)->revokePermissionTo(intval($remove_permission));
                    }
                }

                DB::commit();
                // return [$add_permissions, $remove_permissions, $all_permission];
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->back()
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }

            // Creates Json for Sidebar Menus
            JsonService::createAdminSidebarMenuJson();
            // Creates Json for Role Permissions
            $role = Role::with(['permissions'])->find($acl->fk_role_id);
            JsonService::createRolePermissionJson($role);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.acl.index'))
                ->with('success', __('app.record_updated'));
        }
        $roles = Role::backend()->get();
        $controller = DbControllerRoute::whereHas('permission')->with(['permission'])->where('fk_controller_id', $acl->fk_controller_id)->get();
        $role = Role::with(['permissions' => function ($query) use ($controller) {
            $query->whereIn('id', $controller->pluck('permission.id')->all());
        }])->find($acl->fk_role_id);
        $selected_permission = $role->permissions->pluck('id')->all();
        return view('admin.assign_user_access.edit', compact('roles', 'selected_permission', 'acl'));
    }
}

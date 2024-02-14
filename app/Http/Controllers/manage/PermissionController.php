<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\DbControllerRoute;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Permission::query();
            $actions = [
                'edit' => 'manage.permissions.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn(
                    'action',
                    function ($row) use ($actions, $permissions) {
                        $action = view('components.admin.list-actions', [
                            'actions' => $actions,
                            'model' => $row,
                            'permissions' => $permissions,
                            'encrypt' => true
                        ]);
                        $action = $action->render();

                        return $action;
                    }
                )
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    /**
     * Show form for creating permissions
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:tbl_acl_permissions,name',
                'guard_name' => 'required',
                'fk_tbl_acl_controller_route_id' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            Permission::create($validator->validated());

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.permissions.index'))
                ->with('success', __('Permission created successfully.'));
        }
        $db_controller_routes = DbControllerRoute::whereHas('dbController')->with(['dbController'])->get();
        return view('admin.permissions.create', compact('db_controller_routes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission, Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:tbl_acl_permissions,name,' . $permission->id,
                'guard_name' => 'required',
                'fk_tbl_acl_controller_route_id' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $permission->update($validator->validated());

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.permissions.index'))
                ->with('success', __('Permission updated successfully.'));
        }
        $routes = DbControllerRoute::with(['dbController'])->get();
        return view('admin.permissions.edit', compact('permission', 'routes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->withSuccess(__('Permission deleted successfully.'));
    }
}

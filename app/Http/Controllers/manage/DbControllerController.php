<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Http\Services\JsonService;
use App\Models\DbController;
use App\Models\DbControllerRoute;
use App\Models\Permission;
use App\Models\View\AccessListView;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DbControllerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = AccessListView::query()
                ->filter();
            $actions = [
                'edit' => 'manage.dbcontrollers.edit',
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
        return view('admin.db_controllers.index');
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
                'title' => 'required',
                'resides_at' => 'required',
                'controller_name' => [
                    'required',
                    'regex:/(^([a-zA-Z]+)(\d+)?$)/u'
                ],
                'function_name.*' => [
                    'required',
                    'regex:/(^([a-zA-Z_]+)(\d+)?$)/u'
                ],
            ], [
                'resides_at.required' => 'Controller Location is required.',
                'controller_name.regex' => "Controller Name Format is invalid. May Contain (a-zA-Z) only.",
                'function_name.*.required' => "Function Name is required.",
                'function_name.*.regex' => "Function Name Format is invalid. May Contain (a-zA-Z_) only.",
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $db_controller = $request->only(['title', 'status', 'resides_at', 'controller_name', 'created_by', 'updated_by']);
            $controller = DbController::create($db_controller);
            $controller_name = trim($controller->controller_name);
            if (count($request->function_name) > 0) {
                foreach ($request->function_name as $key => $route) {
                    $route = $request->route[$key];
                    $named_route = $request->named_route[$key];
                    $function_name = trim($request->function_name[$key]);
                    if (!$route) {
                        $route = $controller_name . '/' . $function_name;
                    }
                    if (!$named_route) {
                        $named_route = $controller_name . '.' . $function_name;
                    }
                    $db_controller_route = [
                        'route' => $route,
                        'named_route' => $named_route,
                        'method' => $request->method[$key],
                        'function_name' => $function_name,
                        'fk_controller_id' => $controller->id,
                    ];
                    $db_controller_route = DbControllerRoute::create($db_controller_route);
                    $permission = [
                        'name' => $controller_name . " " . $function_name,
                        'guard_name' => ($controller->resides_at == 'manage') ? 'admin' : $controller->resides_at,
                        'fk_controller_route_id' => $db_controller_route->id
                    ];
                    Permission::create($permission);
                }
            }
            JsonService::createAdminSidebarMenuJson();
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.dbcontrollers.index'))
                ->with('success', __('app.record_created'));
        }
        return view('admin.db_controllers.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DbController  $dbController
     * @return \Illuminate\Http\Response
     */
    public function show(DbController $dbcontroller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DbController  $dbController
     * @return \Illuminate\Http\Response
     */
    public function edit(DbController $dbcontroller, Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'status' => 'required',
                'function_name.*' => [
                    'required',
                    'regex:/(^([a-zA-Z_]+)(\d+)?$)/u'
                ],
            ], [
                'function_name.*.required' => "Function Name is required.",
                'function_name.*.regex' => "Function Name Format is invalid. May Contain (a-zA-Z_) only.",
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $db_controller = $request->only(['title', 'status', 'updated_at']);
            $dbcontroller->fill($db_controller);
            $dbcontroller->update($db_controller);
            $controller = $dbcontroller->fresh();
            $controller_name = trim($controller->controller_name);
            if (count($request->route) > 0) {
                foreach ($request->route as $key => $route) {
                    $route = $request->route[$key];
                    $named_route = $request->named_route[$key];
                    $function_name = trim($request->function_name[$key]);
                    if (!$route) {
                        $route = $controller_name . '/' . $function_name;
                    }
                    if (!$named_route) {
                        $named_route = $controller_name . '.' . $function_name;
                    }
                    $db_controller_route = [
                        'route' => $route,
                        'named_route' => $named_route,
                        'method' => $request->method[$key],
                        'function_name' => $function_name,
                    ];
                    $found = '';
                    if (isset($request->id[$key])) {
                        $found = DbControllerRoute::where('id', $request->id[$key])->first();
                        $found->update($db_controller_route);
                    } else {
                        $db_controller_route['fk_controller_id'] = $controller->id;
                        $found = DbControllerRoute::create($db_controller_route);
                    }
                    if (Permission::where('fk_controller_route_id', $found->id)->count() == 0) {
                        $permission = [
                            'name' => $controller_name . " " . $function_name,
                            'guard_name' => ($controller->resides_at == 'manage') ? 'admin' : $controller->resides_at,
                            'fk_controller_route_id' => $found->id
                        ];
                        Permission::create($permission);
                    }
                }
            }
            JsonService::createAdminSidebarMenuJson();
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.dbcontrollers.index'))
                ->with('success', __('app.record_updated'));
        }
        return view('admin.db_controllers.edit', compact('dbcontroller'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DbController  $dbController
     * @return \Illuminate\Http\Response
     */
    public function destroy(DbController $dbcontroller, Request $request)
    {
        $message = "Controller Restored successully!";
        if ($request->has('restore') && $request->restore == 1) {
            $dbcontroller->restore();
            $dbcontroller->dbControllerRoute()->restore();
        } else {
            if ($dbcontroller->deleteOrFail() === false) {
                return response(
                    ["message" => "Couldn't delete the controller with id {$dbcontroller->id}", "action" => false],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $dbcontroller->dbControllerRoute()->delete();
            $message = "Controller softly deleted successully!";
        }

        return response(["message" => $message, "action" => true], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DbController  $dbController
     * @return \Illuminate\Http\Response
     */
    public function destroyRoute(DbControllerRoute $dbControllerRoute, Request $request)
    {
        if ($dbControllerRoute->deleteOrFail() === false) {
            return response(
                ["message" => "Couldn't delete the media with id {$dbControllerRoute->id}", "action" => false],
                Response::HTTP_BAD_REQUEST
            );
        }
        $message = "Route deleted successully!";

        return response(["message" => $message, "action" => true], Response::HTTP_OK);
    }
}

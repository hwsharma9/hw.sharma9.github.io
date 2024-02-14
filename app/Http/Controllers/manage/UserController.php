<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Services\GateAllow;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = User::query()
                ->whereHas('roles', function ($query) {
                    $query->where('name', '=', 'User');
                })
                ->with(['roles' => function ($query) {
                    $query->select(['id', 'name']);
                }]);
            $actions = [
                'edit' => 'manage.users.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($actions, $permissions) {
                    $action = view('components.admin.list-actions', [
                        'actions' => $actions,
                        'model' => $row,
                        'permissions' => $permissions
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
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.users.index');
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
                    'role_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'username' => 'required',
                    'email' => 'required|email|unique:tbl_users',
                    'designation' => 'required|max:350',
                    'mobile' => 'required|digits:10'
                ],
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $password = passwordGenerator();
            $validated = $validator->validated();
            $validated['password'] = Hash::make($password);
            $user = User::create($validated);
            $user->assignRole($request->role_id);
            // AdminAccountCreationEvent::dispatch($user, $password, "Your MP F&D application account created successfully");

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.users.index'))
                ->with('success', __('app.record_created'));
        }
        $roles = Role::frontend()->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'role_id' => 'required',
                    'first_name' => 'required',
                    'email' => ['required', 'email', Rule::unique('tbl_users')->ignore($user->id)],
                    'designation' => 'required|max:350',
                    'last_name' => 'required',
                    'mobile' => 'required|digits:10',
                    'status' => 'required|boolean'
                ],
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $password = passwordGenerator();
            $validated = $validator->validated();
            if ($request->has('password_resend') && $request->password_resend == 1) {
                $validated['password'] = Hash::make($password);
            }
            $user->update($validated);
            if (!in_array($request->role_id, $user->roles->pluck('id')->all())) {
                $user->syncRoles($request->role_id);
            }

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.users.index'))
                ->with('success', __('app.record_updated'));
        }
        $roles = Role::frontend()->get();
        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}

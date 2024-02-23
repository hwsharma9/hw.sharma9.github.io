<?php

namespace App\Http\Controllers\manage;

use App\Models\Role;
use App\Models\Admin;
use App\Models\MDesignation;
use Illuminate\Http\Request;
use App\Models\AdminUserDetail;
use Illuminate\Validation\Rule;
use App\Http\Services\GateAllow;
use App\Models\OfficeOnboarding;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\ErrorLog;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Admin\AdminAccountCreation;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Admin::query()
                ->with([
                    // 'roles:id,name',
                    'admin_roles' => function ($query) {
                        $query->select([
                            'id',
                            'fk_role_id',
                            'fk_user_id'
                        ])
                            ->where('status', 1)
                            ->with('role:id,name');
                    },
                    'detail.officeonboarding.office:id,title_en',
                    'editor',
                    'creator',
                ])
                ->filter()
                ->when((session('role_name')), function ($query) {
                    $query->when((session('role_name') != 'Super Admin'), function ($query) {
                        $query->where('created_by', auth('admin')->id());
                    })
                        ->when((session('role_name') == 'Super Admin'), function ($query) {
                            $query->where('id', '!=', auth('admin')->id());
                        });
                });
            $actions = [
                'edit' => 'manage.admins.edit',
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
                ->editColumn('officeonboarding', function ($row) {
                    if (isset($row['detail'])) {
                        if (isset($row['detail']['officeonboarding'])) {
                            if (isset($row['detail']['officeonboarding']['office'])) {
                                return $row['detail']['officeonboarding']['office']['title_en'];
                            }
                        }
                    }
                    return '-';
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('editor_name', function ($row) {
                    return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $roles = Role::query()
            ->backend()
            ->active()
            ->get();
        $offices = OfficeOnboarding::query()
            ->with(['office:id,title_en'])
            ->active()
            ->get();
        return view('admin.admins.index', compact('roles', 'offices'));
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
                'role_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => [
                    'required',
                    'email',
                    'unique:tbl_admins'
                ],
                'fk_designation_id' => 'required',
                'mobile' => [
                    'required',
                    'digits:10',
                    'unique:tbl_admins'
                ],
                'captcha' => 'required|captcha'
            ];
            $messages = [
                'email.email' => 'Please enter valid email.',
                'email.unique' => 'This email is already used.',
                'mobile.unique' => 'This contact number is already used.',
                'fk_designation_id.required' => 'The designation is required.',
                'role_id.required' => 'The role name is required.',
            ];
            if (in_array(3, $request->get('role_id'))) {
                $rules['fk_office_onboarding_id'] = 'required';
                $messages['fk_office_onboarding_id.required'] = 'Office Onboarded is required.';
            }
            $validator = Validator::make(
                $request->all(),
                $rules,
                $messages
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            DB::beginTransaction();
            try {
                // Generating random password
                $password = 'password'; //passwordGenerator();

                // Getting only validated records
                $validated = $validator->validated();
                unset($validated['captcha'], $validated['fk_office_onboarding_id'], $validated['role_id']);
                $admin_details = [];
                $validated['first_name'] = ucfirst($validated['first_name']);
                $validated['last_name'] = ucfirst($validated['last_name']);
                $validated['email'] = strtolower($validated['email']);
                $validated['password'] = Hash::make($password);

                // Creating Admin record
                $admin = Admin::create($validated);


                if (!$request->filled('fk_office_onboarding_id')) {
                    $fk_office_onboarding_id = auth('admin')->user()->detail ? auth('admin')->user()->detail->fk_office_onboarding_id : null;
                    $admin_details['fk_office_onboarding_id'] = $fk_office_onboarding_id ? $fk_office_onboarding_id : null;
                } elseif ($request->filled('fk_office_onboarding_id')) {
                    $admin_details['fk_office_onboarding_id'] = $request->fk_office_onboarding_id;
                }
                $admin_details['fk_admin_id'] = $admin->id;
                // Creating Admin User Detail record
                $admin_detail = AdminUserDetail::create($admin_details);

                if ($request->role_id) {
                    foreach ($request->role_id as $role_id) {
                        AdminRole::insert([
                            'fk_user_id' => $admin->id,
                            'fk_role_id' => $role_id,
                            'status' => 1,
                            'is_default' => 1,
                            'created_by' => 1,
                            'created_at' => now(),
                        ]);
                        // Assign role to admin created above
                        $admin->assignRole(intval($role_id));
                    }
                }

                // Sending password to registered user
                // $admin->notify(new AdminAccountCreation($admin, $password, "Your account created successfully"));

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->to(route('manage.admins.create'))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.admins.index'))
                ->with('success', __('app.record_created'));
        }
        // Get active backend roles
        $roles = Role::backend()->ByRole()->active()->get();
        // Get active office onboardings with offices
        $office_onboardings = OfficeOnboarding::query()
            ->with(['office:id,title_en'])
            ->select('id', 'nodal_name', 'fk_office_id')
            ->active()
            ->get();
        // Get active designations
        $designations = MDesignation::active()->get();
        return view('admin.admins.create', compact('roles', 'office_onboardings', 'designations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin, Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'role_id' => 'required',
                'first_name' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('tbl_admins')->ignore($admin->id)
                ],
                'mobile' => [
                    'required',
                    'digits:10',
                    Rule::unique('tbl_admins')->ignore($admin->id)
                ],
                'fk_designation_id' => 'required',
                'last_name' => 'required',
                'status' => 'required',
                'captcha' => 'required|captcha'
            ];
            $messages = [
                'email.email' => 'Please enter valid email.',
                'email.unique' => 'This email is already used.',
                'mobile.unique' => 'This contact number is already used.',
                'fk_designation_id.required' => 'The designation is required.',
                'role_id.required' => 'The role name is required.',
            ];
            if (in_array(3, $request->get('role_id'))) {
                $rules['fk_office_onboarding_id'] = 'required';
                $messages['fk_office_onboarding_id.required'] = 'Office Onboarded is required.';
            }
            $validator = Validator::make(
                $request->all(),
                $rules,
                $messages
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();
            try {
                $roles = Role::backend()->get();
                $validated = $validator->validated();
                unset($validated['captcha'], $validated['fk_office_onboarding_id'], $validated['role_id']);
                $validated['first_name'] = ucfirst($validated['first_name']);
                $validated['last_name'] = ucfirst($validated['last_name']);
                $validated['email'] = strtolower($validated['email']);

                $admin->fill($validated);
                $admin->save();

                // If any change occure in role
                // if (count(array_diff($roles->pluck('id')->all(), $request->role_id)) > 0) {
                // Sync the roles in table
                // $admin->syncRoles($request->role_id);
                // }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->to(route('manage.admins.edit', $admin->id))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.admins.index'))
                ->with('success', __('app.record_updated'));
        }
        $roles = Role::backend()->get();
        $office_onboardings = OfficeOnboarding::with(['office'])->select('id', 'nodal_name', 'fk_office_id')->where('status', 1)->get();
        $designations = MDesignation::get();
        return view('admin.admins.edit', compact('roles', 'admin', 'office_onboardings', 'designations'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

    public function getUsersByRole()
    {
        $role_id = request('role_id');
        $auth_id = request('auth_id');
        $records = Admin::whereHas('roles', function ($query) use ($role_id, $auth_id) {
            $query->where('id', $role_id)
                ->where('id', '!=', $auth_id);
        })->get();
        return response()->json(['records' => $records]);
    }

    public function getContentManagers()
    {
        $name = request('term');
        $records = [];
        if ($name) {
            $records = Admin::select(['id', 'first_name', 'last_name', 'username'])
                ->whereHas('roles', function ($query) {
                    $query->where('id', 4);
                })->where('first_name', 'like', '%' . $name . '%')->get();
            $records = $records->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'text' => $admin->master_name,
                ];
            });
        }
        return response()->json(['records' => $records]);
    }
}

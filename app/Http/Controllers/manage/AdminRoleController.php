<?php

namespace App\Http\Controllers\manage;

use App\Models\Role;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Http\Services\GateAllow;
use App\Models\OfficeOnboarding;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ErrorLog;
use App\Models\MAdditionalChargeReason;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AdminRoleController extends Controller
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
            $actions = 'manage.admin_roles.create';
            $permissions = GateAllow::for($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($permissions) {
                    $action = '';
                    if ($permissions) {
                        $action = '<a href="' . route('manage.admin_roles.create', ['admin' => encrypt($row->id)]) . '" class="btn btn-secondary"><i class="fas fa-plus"></i></a>';
                    }
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
        $roles = Role::backend()->get();
        $offices = OfficeOnboarding::with(['office:id,title_en'])->get();
        return view('admin.admin_roles.index', compact('roles', 'offices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Admin $admin)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'role' => 'required',
                'actual_admin_user_id' => 'required',
                'from_date' => 'required',
                'to_date' => 'required',
                'fk_reason_id' => 'required',
                'verification_doc' => [
                    // 'required',
                    'mimes:jpeg,jpg,png,pdf',
                    'max:512' // Max file upload size is 512 KB
                ],
                'remark' => 'required',
                'captcha' => 'required|captcha'
            ];
            $messages = [
                'role' => 'Role is required.',
                'actual_admin_user_id' => 'User is required.',
                'from_date' => 'From date is required.',
                'to_date' => 'To date is required.',
                'fk_reason_id' => 'Reason is required.',
                'verification_doc' => [
                    'Verification document is required.'
                ],
                'remark' => 'Remark is required.',
                'captcha' => 'Security Code is required.'
            ];
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
                $validated = $validator->validated();
                $role_id = (int) $validated['role'];
                unset($validated['role']);
                $validated['from_date'] = date('Y-m-d', strtotime($validated['from_date']));
                $validated['to_date'] = date('Y-m-d', strtotime($validated['to_date']));
                $validated['fk_role_id'] = $role_id;
                $validated['fk_reason_id'] = (int) $validated['fk_reason_id'];
                $validated['actual_admin_user_id'] = (int) $validated['actual_admin_user_id'];
                $validated['fk_user_id'] = (int) $admin->id;

                // If user has already alloted this role
                if (AdminRole::where(['fk_role_id' => $validated['fk_role_id'], 'fk_user_id' => $validated['fk_user_id']])->count()) {
                    // Through error exception
                    throw new Exception("User has already alloted this role.");
                }

                // If user tried to allot additional charge to himself
                // if ($admin->id == $validated['fk_user_id']) {
                //     // Through error exception
                //     throw new Exception("<b>Sorry!</b> You do not have permission to assign additional charge for himself.");
                // }

                // Create new role for admin
                $admin_role = AdminRole::create($validated);

                // If user is not alloted this role managed by spatie
                if (!$admin->hasRole($admin_role->fk_role_id)) {
                    // Assign role to user for spatie
                    $admin->assignRole($admin_role->fk_role_id);
                }

                $new_file_name = null;
                // If file uploaded
                if ($request->hasFile('verification_doc')) {
                    // Get the file
                    $file = $request->file('verification_doc');
                    // Get the file name without extension
                    $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    // Rename the file
                    $new_file_name = 'Doc_' . substr($file_name, 0, 15) . round(microtime(true)) . mt_rand();
                }
                // Uploaded the file with new name
                $admin_role->uploadModelFile($admin_role, $new_file_name);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                // Store error in error_log table
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return redirect()->back()
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.admin_roles.index'))
                ->with('success', __('app.record_created'));
        }
        $roles = Role::backend()->where('id', '!=', 1)->get();
        $reasons = MAdditionalChargeReason::get();
        $admin_roles = AdminRole::select([
            "id",
            "actual_admin_user_id",
            "fk_user_id",
            "fk_role_id",
            "from_date",
            "to_date",
            "remark",
            "is_default",
            "fk_reason_id",
            "status",
        ])
            ->with([
                'role:id,name',
                'admin:id,first_name,last_name,username',
                'actual_admin:id,first_name,last_name,username',
                'reason:id,name',
                'upload:id,uploadable_id,original_name'
            ])
            ->where('fk_user_id', $admin->id)
            ->latest()
            ->get();
        return view('admin.admin_roles.create', compact('roles', 'admin', 'reasons', 'admin_roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminRole  $admin_role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Admin $admin, AdminRole $admin_role)
    {
        if ($request->ajax()) {
            $rules = [
                'to_date' => 'required',
                'verification_doc' => [
                    'mimes:jpeg,jpg,png,pdf',
                    'max:512' // Max file upload size is 512 KB
                ],
                'remark' => 'required',
            ];
            $messages = [
                'to_date' => 'To date is required.',
                'verification_doc' => [
                    'Verification document is required.'
                ],
                'remark' => 'Remark is required.',
            ];
            $validator = Validator::make(
                $request->all(),
                $rules,
                $messages
            );

            if ($validator->fails()) {
                return [
                    "message" => "The given data was invalid.",
                    "errors" => $validator->errors()
                ];
            }
            DB::beginTransaction();
            try {
                $validated = $validator->validated();
                $validated['to_date'] = date('Y-m-d', strtotime($validated['to_date']));
                $admin_role->fill($validated);
                $admin_role->save();

                if (request()->file()) {
                    // Loop all file type inputs
                    foreach (request()->file() as $file_input_name => $file) {
                        if (request()->hasFile($file_input_name)) {
                            $image = $admin_role->upload;
                            if ($image) {
                                // delete the old image from storage and database.
                                $image->delete();
                            }
                            $new_file_name = '';
                            if ($request->hasFile($file_input_name)) {
                                $file = $request->file($file_input_name);
                                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                $new_file_name = 'Doc_' . substr($file_name, 0, 15) . round(microtime(true)) . mt_rand();
                            }
                            $admin_role->uploadModelFile($admin_role, $new_file_name);
                        }
                    }
                }
                $admin_role = $admin_role->load([
                    'role:id,name',
                    'admin:id,first_name,last_name,username',
                    'actual_admin:id,first_name,last_name,username',
                    'reason:id,name',
                    'upload:id,uploadable_id,original_name'
                ]);
                DB::commit();
                return [
                    'message' => __('app.record_created'),
                    'status' => 'success',
                    'data' => $admin_role,
                ];
            } catch (\Throwable $th) {
                DB::rollback();
                // Store error in error_log table
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return response()->json([
                    'message' => __('app.went_wrong'),
                    'status' => 'error',
                    'data' => null
                ]);
            }
        }
        return view('admin.admin_roles.create', compact('user_role'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminRole  $admin_role
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminRole $admin_role)
    {
        //
    }

    public function updateStatus(AdminRole $admin_role, Request $request)
    {
        $admin_role->status = $request->status;
        $message = "Nothing updated!";
        $response = 'error';
        if ($admin_role->isDirty('status')) {
            $message = "Status updated successfully!";
            $response = 'success';
        }
        $admin_role->save();
        return response()->json([
            'status' => $response,
            'message' => $message,
            'admin_role_id' => $admin_role->id,
            'status_html' => DisplayStatus($admin_role->status)
        ]);
    }
}

<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\MDepartment;
use App\Models\MOffice;
use App\Models\OfficeOnboarding;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OfficeOnboardingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = OfficeOnboarding::query()
                ->with([
                    'department:id,title_en',
                    'office:id,title_en',
                    'editor',
                    'creator',
                ])
                ->filter();
            $actions = [
                'edit' => 'manage.officeonboardings.edit',
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
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
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
        $offices = MOffice::get();
        $departments = MDepartment::get();
        return view('admin.office_onboarding.index', compact('offices', 'departments'));
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
                    'fk_department_id' => 'required',
                    'nodal_name' => 'required',
                    'nodal_contact_number' => [
                        'required',
                        'regex:/[0-9]{10}/',
                        'unique:tbl_office_onboardings'
                    ],
                    'fk_office_id' => [
                        'required',
                        'unique:tbl_office_onboardings'
                    ],
                    'nodal_email' => [
                        'required',
                        'email',
                        'unique:tbl_office_onboardings'
                    ],
                    'office_address' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'fk_department_id.required' => 'Please select department',
                    'nodal_name.required' => 'Please enter nodal name',
                    'nodal_contact_number.required' => 'Please enter nodal contact number',
                    'nodal_contact_number.regex' => 'Please enter valid contact number',
                    'nodal_contact_number.unique' => 'This contact number is already used.',
                    'fk_office_id.required' => 'The office is required',
                    'fk_office_id.unique' => 'This office is already onboarded.',
                    'nodal_email.required' => 'Please enter nodal email',
                    'nodal_email.email' => 'Please enter valid email',
                    'nodal_email.unique' => 'This email is already used.',
                    'office_address.required' => 'Please enter office address'
                ]
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            OfficeOnboarding::create($validated);
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.officeonboardings.index'))
                ->with('success', __('app.record_created'));
        }
        $departments = MDepartment::select('id', 'title_en')->active()->get();
        $offices = MOffice::select('id', 'fk_department_id', 'title_en')->get();
        return view('admin.office_onboarding.create', compact('departments', 'offices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeOnboarding  $officeOnboarding
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeOnboarding $officeOnboarding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeOnboarding  $officeOnboarding
     * @return \Illuminate\Http\Response
     */
    public function edit(OfficeOnboarding $officeonboarding, Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'fk_department_id' => 'required',
                    'nodal_name' => 'required',
                    'nodal_contact_number' => [
                        'required',
                        'regex:/[0-9]{10}/',
                        Rule::unique('tbl_office_onboardings')->ignore($officeonboarding->id)
                    ],
                    'fk_office_id' => [
                        'required',
                        Rule::unique('tbl_office_onboardings')->ignore($officeonboarding->id)
                    ],
                    'nodal_email' => [
                        'required',
                        'email',
                        Rule::unique('tbl_office_onboardings')->ignore($officeonboarding->id)
                    ],
                    'office_address' => 'required',
                    'status' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'fk_department_id.required' => 'Please select department.',
                    'nodal_name.required' => 'Please enter nodal name.',
                    'nodal_contact_number.required' => 'Please enter nodal contact number.',
                    'nodal_contact_number.regex' => 'Please enter valid contact number.',
                    'nodal_contact_number.unique' => 'This contact number is already used.',
                    'fk_office_id.required' => 'The office is required.',
                    'fk_office_id.unique' => 'This office is already onboarded.',
                    'nodal_email.required' => 'Please enter nodal email.',
                    'nodal_email.email' => 'Please enter valid email.',
                    'nodal_email.unique' => 'This email is already used.',
                    'office_address.required' => 'Please enter office address.',
                    'captcha.required' => 'Please enter captcha.',
                ]
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            $officeonboarding->fill($validated);
            $officeonboarding->save();
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.officeonboardings.index'))
                ->with('success', __('app.record_updated'));
        }
        $departments = MDepartment::select('id', 'title_en')->active()->get();
        $offices = MOffice::select('id', 'fk_department_id', 'title_en')->get();
        return view('admin.office_onboarding.edit', compact('officeonboarding', 'departments', 'offices'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeOnboarding  $officeOnboarding
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfficeOnboarding $officeOnboarding)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\ErrorLog;
use App\Models\MAdminCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AssignedCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * \@return \Illuminate\Http\Response
     */
    public function index()
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if (request()->ajax()) {
            $data = MAdminCourse::query()
                ->select(['m_admin_courses.*'])
                ->with([
                    'courseCategory:id,category_name_en',
                    'admin:id,first_name,last_name,username',
                    'categoryCourse' => function ($query) {
                        $query->select(['id', 'course_name_en'])->with(['course']);
                    },
                    'courseContent' => function ($query) {
                        $query->with([
                            'requests' => function ($query) {
                                $query->with(['requestNotification' => function ($query) {
                                    $query->whereNull('read_at')->where('notifiable_id', auth()->id());
                                }])->where('status', '!=', 0)->latest();
                            }
                        ]);
                    },
                    'editor:id,first_name,last_name,username',
                    'creator:id,first_name,last_name,username'
                ])
                ->when($department_id, function ($query) use ($department_id) {
                    $query->whereHas('admin', function ($query) use ($department_id) {
                        $query->whereHas('detail', function ($query) use ($department_id) {
                            $query->whereHas('officeonboarding', function ($query) use ($department_id) {
                                $query->where('fk_department_id', $department_id);
                            });
                        });
                    });
                })
                ->active()
                ->filter();
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) {
                    $action = '';
                    $actions =
                        [
                            'create' => 'manage.courses.create',
                            'edit' => 'manage.courses.edit'
                        ];
                    $permissions = GateAllow::forAll($actions);
                    if ($permissions) {
                        if ($row->courseContent) {
                            $params = [
                                'course' => encrypt($row['courseContent']['id']),
                                'fk_course_category_courses_id' => encrypt($row->fk_course_category_courses_id)
                            ];
                            $count_requests = $row->courseContent?->requests->count();
                            if ($row->courseContent->requests && $row->courseContent->requests?->first()?->requestNotification) {
                                $params['read_notification'] = 1;
                            }
                            $route = route('manage.courses.edit', $params);
                            $action = '<a href="' . $route . '" class="btn btn-secondary" title="Click to create contents"><i class="fas fa-plus"></i></a>'; //<span class="badge bg-success">' . $count_requests . '</span>
                        } else {
                            $action = '<a href="' . route('manage.courses.create', ['fk_course_category_courses_id' => encrypt($row->fk_course_category_courses_id)]) . '" class="btn btn-secondary" title="Click to create contents"><i class="fas fa-plus"></i></a>';
                        }
                    }
                    return $action;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('course_status', function ($row) {
                    return $row->categoryCourse?->course ? CourseStatus($row->categoryCourse->course->course_status) : '';
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->editColumn('editor_name', function ($row) {
                    return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->rawColumns(['action', 'status', 'course_status'])
                ->make(true);
        }
        return view('admin.assigned_courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'captcha' => 'required|captcha',
                ],
                [
                    'captcha.required' => 'Security Code is required',
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
                $validated = $validator->validated();
                $model = MAdminCourse::create($validated);
                $model->uploadModelFile($model);


                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->to(route('manage.assigned_courses.create'))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.assigned_courses.index'))
                ->with('success', __('app.record_created'));
        }
        return view('admin.assigned_courses.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MAdminCourse  $assigned_course
     * @return \Illuminate\Http\Response
     */
    public function edit(MAdminCourse $assigned_course, Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'status' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'status.required' => 'Status is required',
                    'captcha.required' => 'Security Code is required',
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
                $validated = $validator->validated();
                $assigned_course->fill($validated);
                $assigned_course->save();

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->to(route('manage.assigned_courses.edit'))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.assigned_courses.index'))
                ->with('success', __('app.record_updated'));
        }
        return view('admin.assigned_courses.edit');
    }
}

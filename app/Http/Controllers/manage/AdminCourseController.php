<?php

namespace App\Http\Controllers\manage;

use App\Models\Admin;
use App\Models\MAdminCourse;
use Illuminate\Http\Request;
use App\Http\Services\GateAllow;
use App\Http\Controllers\Controller;
use App\Models\MCourseCategory;
use App\Models\MCourseCategoryCourse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
                    'categoryCourse:id,course_name_en',
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
                        // ->where('created_by', auth('admin')->id());
                    });
                })
                ->filter();
            $actions = [
                'edit' => 'manage.admin_courses.edit',
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
                ->editColumn('editor_name', function ($row) {
                    return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        $course_categories = MCourseCategory::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('fk_department_id', $department_id);
            })
            ->select([
                'id',
                'fk_department_id',
                'category_name_en',
            ])
            ->with(['courses' => function ($query) {
                $query->select(['id', 'fk_course_category_id', 'course_name_en'])
                    ->active();
            }])
            ->active()
            ->get();
        return view('admin.admin_courses.index', compact('course_categories'));
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
                    'admin' => 'required',
                    'course_category_id' => 'required',
                    'course_category_courses_id' => [
                        'required',
                        Rule::unique('m_admin_courses', 'fk_course_category_courses_id')->where(function ($query) {
                            return $query->where('fk_admin_id', request()->admin);
                        })
                    ],
                    'captcha' => 'required|captcha',
                ],
                [
                    'admin.required' => 'Content Manager is required',
                    'course_category_id.required' => 'Course Category is required',
                    'course_category_courses_id.required' => 'Course is required',
                    'captcha.required' => 'Security Code is required',
                ]
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();
            $validated['fk_admin_id'] = $validated['admin'];
            $validated['fk_course_category_id'] = $validated['course_category_id'];
            $validated['fk_course_category_courses_id'] = $validated['course_category_courses_id'];
            unset($validated['admin'], $validated['course_category_id'], $validated['course_category_courses_id']);
            MAdminCourse::create($validated);

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.admin_courses.index'))
                ->with('success', __('app.record_created'));
        }
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        $content_managers = Admin::select(['id', 'first_name', 'last_name', 'username'])
            ->whereHas('admin_roles', function ($query) {
                $query->where('fk_role_id', 4) // Content Manager Role ID
                    ->where('is_default', 1)
                    ->active();
            })
            ->active()
            ->get();
        $course_categories = MCourseCategory::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('fk_department_id', $department_id);
            })
            ->select([
                'id',
                'fk_department_id',
                'category_name_en',
            ])
            ->with(['courses' => function ($query) {
                $query->select(['id', 'fk_course_category_id', 'course_name_en'])
                    ->active();
            }])
            ->active()
            ->get();
        return view('admin.admin_courses.create', compact('course_categories', 'content_managers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MAdminCourse  $mAdminCourse
     * @return \Illuminate\Http\Response
     */
    public function show(MAdminCourse $mAdminCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MAdminCourse  $mAdminCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MAdminCourse $admin_course)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    // 'admin' => 'required',
                    // 'course' => [
                    //     'required',
                    //     Rule::unique('m_admin_courses', 'fk_course_category_courses_id')->where(function ($query) {
                    //         return $query->where('fk_admin_id', request()->admin);
                    //     })->ignore($admin_course->id)
                    // ],
                    'status' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    // 'admin.required' => 'Content Manager is required',
                    // 'course.required' => 'Course is required',
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

            $validated = $validator->validated();
            // $validated['fk_admin_id'] = $validated['admin'];
            // $validated['fk_course_category_courses_id'] = $validated['course'];
            // unset($validated['admin'], $validated['course']);
            $admin_course->fill($validated);
            $admin_course->save();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.admin_courses.index'))
                ->with('success', __('app.record_updated'));
        }
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        $content_managers = Admin::select(['id', 'first_name', 'last_name', 'username'])
            ->whereHas('admin_roles', function ($query) {
                $query->where('fk_role_id', 4) // Content Manager Role ID
                    ->where('is_default', 1)
                    ->active();
            })
            ->active()
            ->get();
        $courses = MCourseCategoryCourse::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->whereHas('courseCategory', function ($query) use ($department_id) {
                    $query->where('fk_department_id', $department_id)
                        ->active();
                });
            })
            ->active()
            ->get();
        return view('admin.admin_courses.edit', compact('content_managers', 'courses', 'admin_course'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MAdminCourse  $mAdminCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(MAdminCourse $mAdminCourse)
    {
        //
    }
}

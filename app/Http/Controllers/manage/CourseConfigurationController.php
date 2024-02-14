<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\CourseConfiguration;
use App\Models\ErrorLog;
use App\Models\MCourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class CourseConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if (request()->ajax()) {
            $data = CourseConfiguration::query()
                ->select(['tbl_course_configurations.*'])
                ->with([
                    'courseCategory:id,category_name_en',
                    'categoryCourse',
                    'editor',
                    'creator',
                ])
                ->when($department_id, function ($query) use ($department_id) {
                    $query->whereHas('courseCategory', function ($query) use ($department_id) {
                        $query->whereHas('department', function ($query) use ($department_id) {
                            $query->where('id', $department_id);
                        });
                    });
                })
                ->filter();
            $actions = [
                'edit' => 'manage.course_configurations.edit'
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
        return view('admin.course_configurations.index', compact('course_categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'course_category_id' => 'required',
                    'course_category_courses_id' => [
                        'required',
                        'unique:tbl_course_configurations,fk_course_category_courses_id'
                    ],
                    'is_visible' => 'nullable',
                    'is_downloadable' => 'nullable',
                    'is_course_completion_trackable' => 'nullable',
                    'captcha' => 'required|captcha',
                ],
                [
                    'course_category_id.required' => 'Course Category is required',
                    'course_category_courses_id.required' => 'Course is required',
                    'course_category_courses_id.unique' => 'This Course has already been configured.',
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
                $validated['fk_course_category_id'] = $validated['course_category_id'];
                $validated['fk_course_category_courses_id'] = $validated['course_category_courses_id'];
                if ($request->filled('active_from')) {
                    $validated['active_from'] = date_convert($request->input('active_from'));
                }
                if ($request->filled('active_to')) {
                    $validated['active_to'] = date_convert($request->input('active_to'));
                }
                if ($request->filled('active_from') || $request->filled('active_to')) {
                    $validated['is_active'] = 0;
                }
                if ($request->filled('is_active') && $request->is_active == 'on') {
                    $validated['active_from'] = null;
                    $validated['active_to'] = null;
                    $validated['is_active'] = 1;
                }
                $validated['is_upload_pdf'] = $request->filled('is_upload_pdf') == 'on' ? 1 : 0;
                $validated['is_upload_video'] = $request->filled('is_upload_video') == 'on' ? 1 : 0;
                $validated['is_upload_ppt'] = $request->filled('is_upload_ppt') == 'on' ? 1 : 0;
                $validated['is_upload_doc'] = $request->filled('is_upload_doc') == 'on' ? 1 : 0;
                $validated['is_upload_pdf_required'] = $request->filled('is_upload_pdf_required') == 'on' ? 1 : 0;
                $validated['is_upload_video_required'] = $request->filled('is_upload_video_required') == 'on' ? 1 : 0;
                $validated['is_upload_ppt_required'] = $request->filled('is_upload_ppt_required') == 'on' ? 1 : 0;
                $validated['is_upload_doc_required'] = $request->filled('is_upload_doc_required') == 'on' ? 1 : 0;
                unset($validated['course_category_id'], $validated['course_category_courses_id']);
                // return [$request->all(), $validated];
                $course = CourseConfiguration::create($validated);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->to(route('manage.course_configurations.create'))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.course_configurations.index'))
                ->with('success', __('app.record_created'));
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
        return view('admin.course_configurations.create', compact('course_categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseConfiguration $course_configuration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, CourseConfiguration $course_configuration)
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'course_category_id' => 'required',
                    'course_category_courses_id' => [
                        'required',
                        Rule::unique('tbl_course_configurations', 'fk_course_category_courses_id')->ignore($course_configuration->id)
                    ],
                    'is_visible' => 'nullable',
                    'is_downloadable' => 'nullable',
                    'is_course_completion_trackable' => 'nullable',
                    'status' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'course_category_id.required' => 'Course Category is required',
                    'course_category_courses_id.required' => 'Course is required',
                    'course_category_courses_id.unique' => 'This Course has already been configured.',
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
                $validated['fk_course_category_id'] = $validated['course_category_id'];
                $validated['fk_course_category_courses_id'] = $validated['course_category_courses_id'];
                if ($request->filled('active_from')) {
                    $validated['active_from'] = date_convert($request->input('active_from'));
                }
                if ($request->filled('active_to')) {
                    $validated['active_to'] = date_convert($request->input('active_to'));
                }
                if ($request->filled('active_from') || $request->filled('active_to')) {
                    $validated['is_active'] = 0;
                }
                if ($request->filled('is_active') && $request->is_active == 'on') {
                    $validated['active_from'] = null;
                    $validated['active_to'] = null;
                    $validated['is_active'] = 1;
                }
                $validated['is_upload_pdf'] = $request->filled('is_upload_pdf') == 'on' ? 1 : 0;
                $validated['is_upload_video'] = $request->filled('is_upload_video') == 'on' ? 1 : 0;
                $validated['is_upload_ppt'] = $request->filled('is_upload_ppt') == 'on' ? 1 : 0;
                $validated['is_upload_doc'] = $request->filled('is_upload_doc') == 'on' ? 1 : 0;
                $validated['is_upload_pdf_required'] = $request->filled('is_upload_pdf_required') == 'on' ? 1 : 0;
                $validated['is_upload_video_required'] = $request->filled('is_upload_video_required') == 'on' ? 1 : 0;
                $validated['is_upload_ppt_required'] = $request->filled('is_upload_ppt_required') == 'on' ? 1 : 0;
                $validated['is_upload_doc_required'] = $request->filled('is_upload_doc_required') == 'on' ? 1 : 0;
                unset($validated['course_category_id'], $validated['course_category_courses_id']);
                $course_configuration->fill($validated);
                $course_configuration->save();
                // dd($request->all(), $validated);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->to(route('manage.course_configurations.edit'))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.course_configurations.index'))
                ->with('success', __('app.record_updated'));
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
        return view('admin.course_configurations.edit', compact('course_categories', 'course_configuration'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseConfiguration $course_configuration)
    {
        //
    }
}

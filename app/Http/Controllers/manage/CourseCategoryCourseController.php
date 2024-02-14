<?php

namespace App\Http\Controllers\manage;

use Illuminate\Http\Request;
use App\Models\MCourseCategory;
use App\Http\Services\GateAllow;
use App\Http\Controllers\Controller;
use App\Models\MCourseCategoryCourse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CourseCategoryCourseController extends Controller
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
            $data = MCourseCategoryCourse::query()
                ->select(['m_course_category_courses.*'])
                ->with([
                    'courseCategory',
                    'editor:id,first_name,last_name,username',
                    'creator:id,first_name,last_name,username'
                ])
                ->when($department_id, function ($query) use ($department_id) {
                    $query->whereHas('courseCategory', function ($query) use ($department_id) {
                        $query->where('fk_department_id', $department_id);
                    });
                })
                ->filter();
            $actions = [
                'edit' => 'manage.course_category_courses.edit',
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
        $course_categories = MCourseCategory::when($department_id, function ($query) use ($department_id) {
            $query->where('fk_department_id', $department_id);
        })
            ->select(['id', 'category_name_en'])
            ->active()
            ->get();
        return view('admin.course_category_courses.index', compact('course_categories'));
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
                    'course_category' => 'required',
                    'course_name_hi.*' => 'required',
                    'course_name_en.*' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'course_category.required' => 'Course Category is required',
                    'course_name_hi.required' => 'Title in Hindi is required',
                    'course_name_en.required' => 'Title in English is required',
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
            if (count($request->course_name_hi) > 0) {
                foreach ($request->course_name_hi as $key => $route) {
                    $category_course['fk_course_category_id'] = $validated['course_category'];
                    $category_course['course_name_hi'] = $route;
                    $category_course['course_name_en'] = $validated['course_name_en'][$key];
                    MCourseCategoryCourse::create($category_course);
                }
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.course_category_courses.index'))
                ->with('success', __('app.record_created'));
        }
        $course_categories = MCourseCategory::when($department_id, function ($query) use ($department_id) {
            $query->where('fk_department_id', $department_id);
        })
            ->select(['id', 'category_name_en'])
            ->active()
            ->get();
        return view('admin.course_category_courses.create', compact('course_categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MCourseCategoryCourse  $course_category_course
     * @return \Illuminate\Http\Response
     */
    public function show(MCourseCategoryCourse $course_category_course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MCourseCategoryCourse  $course_category_course
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MCourseCategoryCourse $course_category_course)
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'course_category' => 'required',
                    'course_name_hi' => 'required',
                    'course_name_en' => 'required',
                    'status' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'course_category.required' => 'Course Category is required',
                    'course_name_hi.required' => 'Title in Hindi is required',
                    'course_name_en.required' => 'Title in English is required',
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
            $validated['fk_course_category_id'] = $validated['course_category'];
            unset($validated['course_category']);
            $course_category_course->fill($validated);
            $course_category_course->save();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.course_category_courses.index'))
                ->with('success', __('app.record_updated'));
        }
        $course_categories = MCourseCategory::when($department_id, function ($query) use ($department_id) {
            $query->where('fk_department_id', $department_id);
        })
            ->select(['id', 'category_name_en'])
            ->active()
            ->get();
        return view('admin.course_category_courses.edit', compact('course_category_course', 'course_categories'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MCourseCategoryCourse  $course_category_course
     * @return \Illuminate\Http\Response
     */
    public function destroy(MCourseCategoryCourse $course_category_course)
    {
        //
    }
}

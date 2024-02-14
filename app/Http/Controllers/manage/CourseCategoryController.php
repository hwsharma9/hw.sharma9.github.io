<?php

namespace App\Http\Controllers\manage;

use App\Models\Course;
use App\Models\MDepartment;
use Illuminate\Http\Request;
use App\Models\MCourseCategory;
use App\Http\Services\GateAllow;
use App\Http\Controllers\Controller;
use App\Models\MCourseCategoryCourse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CourseCategoryController extends Controller
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
            $data = MCourseCategory::query()
                ->select(['m_course_categories.*'])
                ->with([
                    'department:id,title_en',
                    'editor:id,first_name,last_name,username',
                    'creator:id,first_name,last_name,username'
                ])
                ->when($department_id, function ($query) use ($department_id) {
                    $query->whereHas('department', function ($query) use ($department_id) {
                        $query->where('id', $department_id);
                    });
                })
                ->filter();
            $actions = [
                'edit' => 'manage.course_categories.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            $has_category_courses_permissions = GateAllow::for('manage.course_category_courses.index');
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
                ->editColumn('category_name_en_link', function ($row) use ($has_category_courses_permissions) {
                    if ($has_category_courses_permissions) {
                        return '<a href="' . route('manage.course_category_courses.index', ['course_category' => encrypt($row->id)]) . '">' . $row->category_name_en . '</a>';
                    } else {
                        return $row->category_name_en;
                    }
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->rawColumns(['action', 'status', 'category_name_en_link'])
                ->make(true);
        }
        $departments = MDepartment::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('id', $department_id);
            })
            ->active()->get();
        // $course_categories = MCourseCategory::active()->get();
        return view('admin.course_categories.index', compact('departments'));
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
                    'department' => 'required',
                    'category_name_hi.*' => 'required',
                    'category_name_en.*' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'department.required' => 'Course Category is required',
                    'category_name_hi.required' => 'Title in Hindi is required',
                    'category_name_en.required' => 'Title in English is required',
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
            if (count($request->category_name_hi) > 0) {
                foreach ($request->category_name_hi as $key => $route) {
                    $course_category['fk_department_id'] = $validated['department'];
                    $course_category['category_name_hi'] = $route;
                    $course_category['category_name_en'] = $validated['category_name_en'][$key];
                    MCourseCategory::create($course_category);
                }
            }
            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.course_categories.index'))
                ->with('success', __('app.record_created'));
        }
        $departments = MDepartment::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('id', $department_id);
            })
            ->active()->get();
        return view('admin.course_categories.create', compact('departments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MCourseCategory  $course_category
     * @return \Illuminate\Http\Response
     */
    public function show(MCourseCategory $course_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MCourseCategory  $course_category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, MCourseCategory $course_category)
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'department' => 'required',
                    'category_name_hi' => 'required',
                    'category_name_en' => 'required',
                    'status' => 'required',
                    'captcha' => 'required|captcha',
                ],
                [
                    'department.required' => 'Course Category is required',
                    'category_name_hi.required' => 'Title in Hindi is required',
                    'category_name_en.required' => 'Title in English is required',
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
            $validated['fk_department_id'] = $validated['department'];
            unset($validated['department']);
            $course_category->fill($validated);
            $course_category->save();

            $redirect = redirect();
            return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.course_categories.index'))
                ->with('success', __('app.record_updated'));
        }
        $departments = MDepartment::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('id', $department_id);
            })
            ->active()->get();
        return view('admin.course_categories.edit', compact('departments', 'course_category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MCourseCategory  $mCourseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MCourseCategory $mCourseCategory)
    {
        //
    }
}

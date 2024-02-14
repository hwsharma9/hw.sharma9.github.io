<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseApprovalRequest;
use App\Models\ErrorLog;
use App\Models\MCourseLog;
use App\Notifications\Admin\RequestToApproveCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CourseApprovalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        if (request()->ajax()) {
            $data = CourseApprovalRequest::query()
                ->select(['tbl_course_approval_requests.*'])
                ->with([
                    'course' => [
                        'assignedAdmin' => [
                            'courseCategory:id,category_name_en',
                            'categoryCourse:id,course_name_en'
                        ],
                        'topics:id,title,fk_course_id'
                    ],
                    'editor',
                    'creator',
                ])
                ->where('fk_course_id', $course->id);
            $role_name = session('role_name');
            if ($role_name == 'Content Manager') {
                $data = $data->where('status', '>', 0);
            }
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($role_name) {
                    $action = '';
                    if ($role_name == 'Content Manager') {
                        $action = '<button type="button" class="btn btn-primary view-remark" title="View Remark for this request!" data-url="' . route('manage.course.request.edit', ['course' => $row->fk_course_id, 'approval_request' => $row->id]) . '" data-remark="' . ($row->remark) . '" data-status="' . $row->status . '"><i class="fas fa-eye"></i></button>';
                    } else {
                        if ($row->status == 0 || $row->status == 1) {
                            $title = ($row->remark ? 'Edit' : 'Add') . ' Remark for this request!';
                            $action = '<button type="button" class="btn btn-primary edit-remark" title="' . $title . '" data-url="' . route('manage.course.request.edit', ['course' => $row->fk_course_id, 'approval_request' => $row->id]) . '" data-remark="' . ($row->remark) . '" data-status="' . $row->status . '"><i class="fas fa-edit"></i></button>';
                        } else {
                            $action = '<button type="button" class="btn btn-primary view-remark" title="View Remark for this request!" data-url="' . route('manage.course.request.edit', ['course' => $row->fk_course_id, 'approval_request' => $row->id]) . '" data-remark="' . ($row->remark) . '" data-status="' . $row->status . '"><i class="fas fa-eye"></i></button>';
                        }
                    }
                    return $action;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('editor_name', function ($row) {
                    return $row?->editor?->name ?? $row?->creator?->name;
                })
                ->editColumn('updated_topics', function ($row) {
                    $topics = $row->course->topics->whereIn('id', explode(',', $row->topic_ids))->pluck('title')->implode(',');
                    return $topics;
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 0 ? 'Submitted for Approval' : ($row->status == 1 ? 'Send for Correction' : 'Approved');
                })
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Course $course)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'remark' => 'required',
                    // 'captcha' => 'required|captcha',
                ],
                [
                    'remark.required' => 'Remark is required',
                    // 'captcha.required' => 'Security Code is required',
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
                $validated['fk_course_id'] = $course->id;
                CourseApprovalRequest::create($validated);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                return
                    redirect()->back()
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return $redirect->route('manage.courses.index')
                ->with('success', __('app.record_created'));
        }
        return view('admin.course_remarks.create', compact('course'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, CourseApprovalRequest $approval_request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Course $course, CourseApprovalRequest $approval_request)
    {
        if (request()->ajax()) {
            DB::beginTransaction();
            try {
                // return [$course, $approval_request, $request->all()];
                $approval_request->fill($request->all());
                $approval_request->saveQuietly();
                if ($request->has('status') && $request->status > 0) {
                    Log::info('old course', $course->toArray());
                    $course->fill(['course_status' => $request->status, 'is_edited' => 0]);
                    $this->resetUpdateColumns($request, $course);

                    // if ($request->status == 2) {
                    //     if ($check_diff = $course->getCheckDiff()) {
                    //         Log::info($check_diff);
                    //         foreach ($check_diff as $column) {
                    //             $update_column = 'update_' . $column;
                    //             if (Schema::hasColumn($course->getTable(), $update_column)) {
                    //                 if ($course->$update_column) {
                    //                     $course->$column = $course->$update_column;
                    //                     $course->$update_column = null;
                    //                     Log::info('Column => ' . $column . ' => ' . $course->$column);
                    //                     Log::info('update_column => ' . $update_column . ' => ' . $course->$update_column);
                    //                     $course->fill([$column => $course->$column, $update_column => $course->$update_column]);
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }

                    Log::info('new course', $course->toArray());
                    $course->saveQuietly();
                    if ($course_uploads = $course->uploads()->withTrashed()->get()) {
                        foreach ($course_uploads as $course_upload) {
                            if ($course_upload->trashed()) {
                                $course_upload->forceDelete();
                            } else {
                                $course_upload
                                    ->where('course_status', '<', $request->status)
                                    ->update(['course_status' => $request->status]);
                            }
                        }
                    }

                    if ($course->topics) {
                        foreach ($course->topics as $topic) {
                            Log::info('Old Topic', $topic->toArray());
                            $topic->fill([
                                'is_edited' => 0,
                                'course_status' => $request->status
                            ]);
                            $this->resetUpdateColumns($request, $topic);
                            // print_r($topic->toArray());
                            // if ($request->status == 2) {
                            //     if ($check_diff = $topic->getCheckDiff()) {
                            //         Log::info($check_diff);
                            //         foreach ($check_diff as $column) {
                            //             $update_column = 'update_' . $column;
                            //             if (Schema::hasColumn($topic->getTable(), $update_column)) {
                            //                 if ($topic->$update_column) {
                            //                     $topic->$column = $topic->$update_column;
                            //                     $topic->$update_column = null;
                            //                     Log::info('Column => ' . $column . ' => ' . $topic->$column);
                            //                     Log::info('update_column => ' . $update_column . ' => ' . $topic->$update_column);
                            //                     $topic->fill([$column => $topic->$column, $update_column => $topic->$update_column]);
                            //                 }
                            //             }
                            //         }
                            //     }
                            // }
                            Log::info('new Topic', $topic->toArray());
                            $topic->saveQuietly();
                            if ($topic_uploads = $topic->uploads()->withTrashed()->get()) {
                                foreach ($topic_uploads as $topic_upload) {
                                    if ($topic_upload->field_name == 'course_video') {
                                        $this->resetUpdateColumns($request, $topic_upload);
                                        $topic_upload->fill(
                                            ['course_status' => $request->status]
                                        );
                                        $topic_upload->where('course_status', '<', $request->status);
                                        $topic_upload->saveQuietly();
                                    } else {
                                        if ($topic_upload->trashed()) {
                                            $topic_upload->forceDelete();
                                        } else {
                                            $topic_upload
                                                ->where('course_status', '<', $request->status)
                                                ->update(['course_status' => $request->status]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    // dd('wait');
                    MCourseLog::where(['fk_course_id' => $course->id])
                        ->whereIn('loggable_type', ["App\Models\Course", "App\Models\CourseTopic", "App\Models\CourseMedia"])
                        ->where('course_status', '<', $request->status)
                        ->update([
                            'course_status' => $request->status
                        ]);
                    if (is_null($approval_request->requestNotification->read_at)) {
                        $approval_request->requestNotification->markAsRead();
                    }
                    if (!is_null($approval_request->fk_notification_id)) {
                        $course->creator->notify(new RequestToApproveCourse($approval_request->refresh()));
                    }
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                if (request()->ajax()) {
                    return [
                        'status' => false,
                        'error' => __('app.went_wrong')
                    ];
                } else {
                    return
                        redirect()->to(route('manage.courses.edit', [
                            'course' => encrypt($course->id),
                            'fk_course_category_courses_id' => encrypt($course->assignedAdmin->fk_course_category_courses_id)
                        ]))
                        ->withInput($request->input())
                        ->with('error', __('app.went_wrong'));
                }
            }
            return [
                'status' => true,
                'message' => __('app.record_updated'),
            ];
        }
    }

    private function resetUpdateColumns(Request $request, &$model)
    {
        if ($request->status == 2) {
            if ($check_diff = $model->getCheckDiff()) {
                Log::info($check_diff);
                foreach ($check_diff as $column) {
                    $update_column = 'update_' . $column;
                    if (Schema::hasColumn($model->getTable(), $update_column)) {
                        if ($model->$update_column) {
                            $model->$column = $model->$update_column;
                            $model->$update_column = null;
                            Log::info('Column => ' . $column . ' => ' . $model->$column);
                            Log::info('update_column => ' . $update_column . ' => ' . $model->$update_column);
                            $model->fill([$column => $model->$column, $update_column => $model->$update_column]);
                        }
                    }
                }
            }
        }
        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseApprovalRequest $approval_request)
    {
        //
    }
}

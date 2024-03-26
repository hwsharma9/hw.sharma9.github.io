<?php

namespace App\Http\Controllers\manage;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Services\GateAllow;
use App\Http\Controllers\Controller;
use App\Models\CourseApprovalRequest;
use App\Models\CourseMedia;
use App\Models\CourseTopic;
use App\Models\ErrorLog;
use App\Models\MAdminCourse;
use App\Models\MCourseCategory;
use App\Notifications\Admin\RequestToApproveCourse;
use App\View\Components\Admin\Course\Topic;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Mews\Captcha\Facades\Captcha;

class CourseController extends Controller
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
            $data = Course::query()
                ->select(['tbl_courses.id', 'tbl_courses.fk_m_admin_course_id', 'tbl_courses.status', 'tbl_courses.course_status', 'tbl_courses.created_by', 'tbl_courses.updated_by', 'tbl_courses.created_at', 'tbl_courses.updated_at'])
                ->when($department_id, function ($query) use ($department_id) {
                    $query->whereHas('assignedAdmin', function ($query) use ($department_id) {
                        $query->whereHas('courseCategory', function ($query) use ($department_id) {
                            $query->whereHas('department', function ($query) use ($department_id) {
                                $query->where('id', $department_id);
                            });
                        });
                    });
                })
                ->with([
                    'assignedAdmin' => [
                        'courseCategory:id,category_name_en',
                        'categoryCourse:id,course_name_en'
                    ],
                    'requests' => function ($query) {
                        $query->with(['requestNotification' => function ($query) {
                            $query->whereNull('read_at')->where('notifiable_id', auth()->id());
                        }])->where('status', 0);
                    },
                    'editor',
                    'creator',
                ])
                ->where('course_status', '>', 0)
                ->filter();
            $actions = [
                // 'edit' => 'manage.courses.edit',
                'show' => 'manage.courses.show',
            ];
            $permissions = GateAllow::forAll($actions);
            $course_statuses = collect(config('constents.course_status'))->except([0]);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($actions, $permissions) {
                    $encrypt = true;
                    $action = '';
                    if (array_key_exists('show', $actions)) {
                        if ($permissions['show']) {
                            $params = ['course' => isset($encrypt) && $encrypt == 1 ? encrypt($row->id) : $row->id];
                            if ($row->requests && $row->requests->first()?->requestNotification) {
                                $params['read_notification'] = 1;
                            }
                            $route = route($actions['show'], $params);
                            $action = '<a class="btn btn-secondary" title="View Model"
                                    href="' . ($route) . '"><i
                                        class="fas fa-eye"></i> <span class="badge bg-success">' . $row->requests->count() . '</span></a>';
                            // $action .= '<a class="btn btn-secondary" title="View Model">Publish</a>';
                            if ($row->course_status >= 2) {
                                $action .= '<form action="' . route('ajax.course.update-status', ['course' => $row->id]) . '" method="POST" name="course_status_form" data-id="' . $row['id'] . '">
                                    <input type="hidden" name="course_status" value="' . (in_array($row['course_status'], [2, 4]) ? 3 : 4) . '">
                                    <button class="btn ' . (in_array($row['course_status'], [2, 4]) ? 'btn-success' : 'btn-warning') . ' publish_course" title="View Model">' . (in_array($row['course_status'], [2, 4]) ? 'Publish' : 'Unpublish') . '</button>
                                </form>';
                            }
                        }
                    }
                    // $action .= '<a class="btn btn-primary" title="Add Model" href="' . route('manage.course.request.create', ['course' => $row['id']]) . '">Add Remark</a>';
                    return $action;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('status', function ($row) {
                    return DisplayStatus($row['status']);
                })
                ->editColumn('course_status', function ($row) use ($course_statuses) {
                    return CourseStatus($row->course_status);
                    // $course_status_dd = '';
                    // foreach ($course_statuses as $key => $value) {
                    //     $course_status_dd .= '<option value="' . $key . '" ' . ($row['course_status'] == $key ? 'selected' : '') . '>' . $value . '</option>';
                    // }
                    //     <select name="course_status">
                    //         <option>Select Status</option>'
                    // . $course_status_dd .
                    // '</select>
                    // <button type="submit">Submit</button>
                    // return '<form method="POST" name="course_status_form" data-id="' . $row['id'] . '">
                    //     <input type="hidden" name="course_status" value="' . (in_array($row['course_status'], [2, 4]) ? 3 : 4) . '">
                    //     <a class="btn btn-secondary publish_course" title="View Model">' . (in_array($row['course_status'], [2, 4]) ? 'Publish' : 'Unpublish') . '</a>
                    // </form>';
                })
                ->editColumn('editor_name', function ($row) {
                    return $row?->editor?->name ?? $row?->creator?->name;
                    // return $row['editor'] ? $row['editor']['name'] . ' (' . $row['editor']['username'] . ')' : ($row['creator'] ? $row['creator']['name'] . ' (' . $row['creator']['username'] . ')' : '');
                })
                ->rawColumns(['action', 'status', 'course_status'])
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
        return view('admin.courses.index', compact('course_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        $alloted_admin = MAdminCourse::query()
            ->where('fk_course_category_courses_id', decrypt($request->fk_course_category_courses_id))
            ->with([
                'courseCategory:id,category_name_en',
                'categoryCourse:id,course_name_en',
            ])
            ->first();
        if ($request->isMethod('post')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'description' => 'required',
                    // 'captcha' => 'required|captcha',
                ],
                [
                    'description.required' => 'Description is required',
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
                $validated['fk_m_admin_course_id'] = $alloted_admin->id;
                $course = Course::create($validated);
                $course->uploadModelFile($course, $request->file('course_thumbnail'), 'course_thumbnail');
                if ($request->has('topic')) {
                    foreach ($request->topic as $key => $value) {
                        $topic = CourseTopic::create([
                            'fk_course_id' => $course->id,
                            'title' => $value['title'],
                            'summary' => $value['summary'],
                        ]);
                        $topic->uploadModelFile($topic, $request->file('topic')[$key], 'topic');
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
                return
                    redirect()->to(route('manage.courses.create', ['fk_course_category_courses_id' => $request->fk_course_category_courses_id]))
                    ->withInput($request->input())
                    ->with('error', __('app.went_wrong'));
            }
            $redirect = redirect();
            return $redirect->route('manage.assigned_courses.index')
                ->with('success', __('app.record_created'));
        }
        $course_categories = MCourseCategory::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('fk_department_id', $department_id);
            })
            ->active()
            ->get();
        $configuration = $alloted_admin?->categoryCourse?->configuration;
        return view('admin.courses.create', compact('course_categories', 'configuration', 'alloted_admin'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        if (request()->has('read_notification')) {
            if ($course->requests) {
                foreach ($course->requests as $request) {
                    if ($request->requestNotification) {
                        $request->requestNotification->markAsRead();
                    }
                }
            }
            return redirect()->route('manage.courses.show', encrypt($course->id));
        }
        $course->load([
            'assignedAdmin',
            'upload' => function ($query) {
                $query->withTrashed();
            },
            'uploads' => function ($query) {
                $query->withTrashed()->latest();
            },
            'topics' => function ($query) {
                $query->where('course_status', '!=', 0)->with([
                    'uploads' => function ($query) {
                        $query->withTrashed();
                    },
                    'logs' => function ($query) {
                        $query
                            ->whereNotNull('prev_data')
                            ->where('course_status', 2)
                            ->latest()
                            ->first();
                    }
                ]);
            },
            'requests' => function ($query) {
                $query->with(['requestNotification' => function ($query) {
                    $query->whereNull('read_at');
                }])->where('status', 0)->latest()->first();
            },
            // 'logs' => function ($query) {
            //     $query
            //         ->whereNotNull('prev_data')
            //         ->where('course_status', 2)
            //         ->latest()
            //         ->first();
            // }
        ]);

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course, Request $request)
    {
        if ($request->isMethod('post') || request()->ajax()) {
            // $captcha = Captcha::src('default');
            // return [$request->all(), $request->file()];
            $validator = Validator::make(
                $request->all(),
                [
                    'description' => 'required',
                    // 'status' => 'required',
                    // 'captcha' => 'required|captcha',
                ],
                [
                    'description.required' => 'Description is required.',
                    // 'status.required' => 'Status is required.',
                    // 'captcha.required' => 'Security Code is required.',
                ]
            );

            if ($validator->fails()) {
                if (request()->ajax()) {
                    return [
                        "message" => "The given data was invalid.",
                        'errors' => view(
                            'components.auth-validation-errors',
                            [
                                'errors' => $validator->errors()
                            ]
                        )->render(),
                        // 'captcha' => $captcha
                    ];
                } else {
                    return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput();
                }
            }
            DB::beginTransaction();
            try {
                // return $request->all();
                $validated = $validator->validated();
                if ($request->has('saved_as') && $request->saved_as == 'request') {
                    if ($course->course_status == 0) {
                        $validated['course_status'] = 1;
                    }
                }
                // return $validated;
                $course->fill($validated);
                $course->save();

                // Upload Latest course media
                $course->uploadModelFile($course, $request->file('course_thumbnail'), 'course_thumbnail');

                // If course has draft media submit it for approval
                if ($request->has('saved_as') && $request->saved_as == 'request') {
                    $draft_course_media = CourseMedia::where(['uploadable_type' => "App\Models\Course", 'course_status' => 0, 'uploadable_id' => $course->id]);
                    if ($draft_course_media->count() == 1) {
                        $draft_course_media->first()->course_status = 1;
                    }
                }

                if ($request->filled('replaced_media_id')) {
                    $ids = explode(',', $request->replaced_media_id);
                    for ($i = 0; $i < count($ids); $i++) {
                        $course_media = CourseMedia::find(decrypt($ids[$i]));
                        if ($course_media->course_status == 0) {
                            $course_media->forceDelete();
                        } else {
                            $course_media->delete();
                        }
                    }
                }
                // echo "<pre>";
                $topics_to_approve = [];
                if ($request->has('topic')) {
                    foreach ($request->topic as $key => $value) {
                        $where = [];
                        if (isset($value['id']) && !is_null($value['id'])) {
                            $where['id'] = $value['id'];
                        }
                        if ($where) {
                            // echo 'update topic';
                            $topic = CourseTopic::find($where['id']);
                            $topic->fill([
                                'fk_course_id' => $course->id,
                                'title' => $value['title'],
                                'summary' => $value['summary'],
                            ]);
                            // $is_dirty = $topic->isDirty();
                            if (isset($request->file('topic')[$key])) {
                                $topic->uploadModelFile($topic, $request->file('topic')[$key], 'topic');
                                // $is_dirty = true;
                            }
                            if ($request->has('saved_as') && $request->saved_as == 'request') {
                                if ($topic->course_status == 0) {
                                    $topic->course_status = 1;
                                }
                                $draft_course_topic_media = CourseMedia::where([
                                    'uploadable_type' => "App\Models\CourseTopic",
                                    'course_status' => 0,
                                    'uploadable_id' => $topic->id
                                ]);
                                if ($draft_course_topic_media->count() == 1) {
                                    $draft_course_topic_media->update(['course_status' => 1]);
                                }
                            }
                            // if ($request->has('saved_as') && $request->saved_as == 'request') {
                            //     if ($topic->is_edited == 0) {
                            //         if ($topic->course_status != 2) {
                            //             $topic->course_status = 1;
                            //         }
                            //         if ($is_dirty || $topic->course_status == 1) {
                            //             $topic->is_edited = 1;
                            //             $is_dirty = true;
                            //         }
                            //     }
                            // } else {
                            //     $topic->is_edited = 1;
                            // }
                            // if ($is_dirty) {
                            //     array_push($topics_to_approve, $topic->id);
                            // }
                            $topic->save();
                        } else {
                            // echo 'create topic';
                            $topic = new CourseTopic;
                            $topic->fill([
                                'fk_course_id' => $course->id,
                                'title' => $value['title'],
                                'summary' => $value['summary'],
                            ]);
                            if ($request->has('saved_as') && $request->saved_as == 'request') {
                                // $topic->is_edited = 1;
                                $topic->course_status = 1;
                            }
                            $topic->save();
                            if (isset($request->file('topic')[$key])) {
                                $topic->uploadModelFile($topic, $request->file('topic')[$key], 'topic');
                            }
                            // array_push($topics_to_approve, $topic->id);
                        }
                        $where_video = [];
                        if (isset($value['course_video_id']) && !is_null($value['course_video_id'])) {
                            $where_video['id'] = $value['course_video_id'];
                        }
                        $course_video = [
                            'file_mime_type' => 'application/video',
                            'original_name' => 'original_name',
                            'field_name' => 'course_video'
                        ];
                        if (isset($value['course_video']) && !is_null($value['course_video'])) {
                            $course_video['file_path'] = $value['course_video'];
                            $course_video['fk_course_id'] = $course->id;
                            if ($where_video) {
                                $upload = CourseMedia::find($value['course_video_id']);
                                $upload->fill($course_video);
                                $upload->save();
                            } else {
                                // return $course_video;
                                $topic->upload()->create($course_video);
                            }
                        } else {
                            $course_video['file_path'] = null;
                            if ($where_video) {
                                $topic->upload()->where($where_video)->update($course_video);
                            }
                        }
                    }
                }

                if ($request->has('saved_as') && $request->saved_as == 'request') {
                    if ($course->requests()->where(['status' => 0])->count() != 0) {
                        // Get last request and edit
                        $last_request = $course->requests()->where(['status' => 0])->latest()->first();
                        $last_request->topic_ids = (!empty($last_request->topic_ids) ? $last_request->topic_ids . ',' : '') . implode(',', $topics_to_approve);
                        $last_request->save();
                    } else {
                        // Create new request
                        $approval_request = CourseApprovalRequest::create([
                            'fk_course_id' => $course->id,
                            // 'topic_ids' => implode(',', $topics_to_approve),
                        ]);
                        if (is_null($approval_request->fk_notification_id)) {
                            auth()->user()->creator->notify(new RequestToApproveCourse($approval_request->refresh()));
                        }
                    }
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                Log::info($th);
                ErrorLog::create([
                    'class_name' => get_class(),
                    'function_name' => __FUNCTION__,
                    'error' => $th->getMessage()
                ]);
                if (request()->ajax()) {
                    return [
                        'status' => false,
                        'error' => __('app.went_wrong'),
                        // 'captcha' => $captcha
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

            if (request()->ajax()) {
                return [
                    'status' => true,
                    'message' => 'Record saved as draft successfully!',
                    // 'captcha' => $captcha,
                ];
            } else {
                $redirect = redirect();
                return (($request->has('action')) ? $redirect->back() : $redirect->route('manage.assigned_courses.index'))
                    ->with('success', __('app.record_updated'));
            }
        }
        $department_id = auth('admin')->user()->detail?->officeonboarding?->fk_department_id;
        $course = $course->load([
            'upload' => function ($query) {
                $query->select(['id', 'file_path', 'file_mime_type', 'original_name', 'uploadable_id']);
            },
            'topics.uploads' => function ($query) {
                $query->select(['id', 'file_path', 'file_mime_type', 'original_name', 'field_name', 'uploadable_id']);
            },
            'requests' => function ($query) {
                $query->where('status', '>', 0);
            }
        ]);

        if (request()->has('read_notification')) {
            if ($course->requests) {
                foreach ($course->requests as $request) {
                    if ($request->requestNotification) {
                        $request->requestNotification->markAsRead();
                    }
                }
            }
            $query = request()->query();
            unset($query['read_notification']);
            return redirect()->to(request()->url() . '?' . http_build_query($query));
        }
        $alloted_admin = MAdminCourse::query()
            ->where('fk_course_category_courses_id', decrypt($request->fk_course_category_courses_id))
            ->with([
                'courseCategory:id,category_name_en',
                'categoryCourse' => function ($query) {
                    $query->active()
                        ->with([
                            'configuration' => function ($query) {
                                $query->active();
                            }
                        ])
                        ->select(['id', 'course_name_en']);
                },
            ])
            ->first();
        $course_categories = MCourseCategory::query()
            ->when($department_id, function ($query) use ($department_id) {
                $query->where('fk_department_id', $department_id);
            })
            ->active()
            ->get();
        $configuration = $alloted_admin?->categoryCourse?->configuration;
        // $action = (new Topic($configuration, null, null))->render();
        return view('admin.courses.edit', compact('course', 'course_categories', 'alloted_admin', 'configuration'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if ($course->topics->count()) {
            foreach ($course->topics as $topic) {
                if ($uploads = $topic->uploads) {
                    foreach ($uploads as $upload) {
                        $upload->delete();
                    }
                }
                $topic->delete();
            }
        }
        $course->delete();
        return redirect()->route('manage.courses.index')
            ->with('success', __('app.record_deleted'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function deleteCourseTopic(CourseTopic $course_topic)
    {
        DB::beginTransaction();
        try {
            if ($course_topic->course_status != 0) {
                return [
                    'status' => true,
                    'message' => 'You are not allowed to delete this topic!',
                ];
            }
            if ($uploads = $course_topic->uploads) {
                foreach ($uploads as $upload) {
                    $upload->delete();
                }
            }
            $course_topic->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            ErrorLog::create([
                'class_name' => get_class(),
                'function_name' => __FUNCTION__,
                'error' => $th->getMessage()
            ]);
            return [
                'status' => false,
                'error' => __('app.went_wrong'),
            ];
        }
        return [
            'status' => true,
            'message' => 'Record deleted successfully!',
        ];
    }

    public function deleteCourseMedia(CourseMedia $course_media)
    {
        $course_media->delete();
        return ['status' => true, 'message' => 'Media deleted successfully.'];
    }

    public function updateCourseStatus(Request $request, Course $course)
    {
        $course->fill($request->only('course_status'));
        $course->save();
        return ['status' => true, 'message' => __('app.record_updated')];
    }
}

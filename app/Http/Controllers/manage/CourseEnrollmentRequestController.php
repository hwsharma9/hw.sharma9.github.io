<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Http\Services\GateAllow;
use App\Models\CourseEnrollment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseEnrollmentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = CourseEnrollment::query()
                ->select(['tbl_course_enrolments.*'])
                ->with([
                    'course' => function ($query) {
                        $query->select([
                            'id',
                            'fk_m_admin_course_id'
                        ])
                            ->with([
                                'assignedAdmin' => [
                                    'courseCategory:id,category_name_en',
                                    'categoryCourse:id,course_name_en'
                                ]
                            ]);
                    },
                    'user:id,first_name,last_name',
                    'editor',
                    'creator',
                ]);
            $actions = [
                'edit' => 'manage.course_enrollment_requests.edit',
            ];
            $permissions = GateAllow::forAll($actions);
            return DataTables::of($data)
                ->addIndexColumn('id')
                ->addColumn('action', function ($row) use ($actions, $permissions) {
                    $encrypt = true;
                    $action = '';
                    if (array_key_exists('edit', $actions)) {
                        if ($permissions['edit']) {
                            if ($row->status == 0) {
                                $action .= '<form action="' . route('manage.course_enrollment_requests.edit', ['course_enrollment_request' => $row->id]) . '" method="POST" class="approve_enrollment_request_form" data-id="' . $row['id'] . '">
                                    <input type="hidden" name="status" value="' . ($row['status'] == 0 ? 1 : 0) . '">
                                    <button class="btn btn-success" title="Approve Enrollment Request">' . ($row->status == 0 ? 'Enroll' : 'Enrolled') . '</button>
                                </form>';
                            }
                        }
                    }
                    return $action;
                })
                ->editColumn('updated_at', function ($row) {
                    return $row['updated_at'] ? date('d-m-Y H:i:s', strtotime($row['updated_at'])) : date('d-m-Y H:i:s', strtotime($row['created_at']));
                })
                ->editColumn('status', function ($row) {
                    return CourseEnrollmentStatus($row['status']);
                })
                ->editColumn('editor_name', function ($row) {
                    return $row?->editor?->name ?? $row?->creator?->name;
                })
                ->rawColumns(['action', 'status', 'course_status'])
                ->make(true);
        }
        return view('admin.course_enrollment_requests.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseEnrollment  $course_enrollment_request
     * @return \Illuminate\Http\Response
     */
    public function show(CourseEnrollment $course_enrollment_request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseEnrollment  $course_enrollment_request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, CourseEnrollment $course_enrollment_request)
    {
        $course_enrollment_request->fill($request->only('status'));
        $course_enrollment_request->save();
        return ['status' => true, 'message' => __('app.record_updated')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CourseEnrollment  $course_enrollment_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseEnrollment $course_enrollment_request)
    {
        //
    }
}

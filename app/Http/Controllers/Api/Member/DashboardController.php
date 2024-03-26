<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enrolled_courses = auth()->user()->enroledCourses->count();
        return response()->json([
            'status' => 200,
            'data' => [
                'enrolled_courses_count' => $enrolled_courses,
                'certificates_count' => 5,
                'completed_courses_count' => 15
            ],
        ]);
    }
}

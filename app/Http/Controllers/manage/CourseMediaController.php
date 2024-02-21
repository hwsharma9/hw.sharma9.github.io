<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;
use App\Models\CourseMedia;
use Illuminate\Http\Request;

class CourseMediaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, CourseMedia $media)
    {
        return response()->download(str_replace('\\', '/',  storage_path() . '/app/public/' .  $media->file_path), $media->original_name);
    }
}

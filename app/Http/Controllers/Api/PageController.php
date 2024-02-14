<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, $slug)
    {
        $page = Page::where('slug', $slug)->first();
        if (!$page) {
            return [
                'status' => 404,
                'data' => [
                    'message' => 'Page not found',
                ]
            ];
        } else {

            return [
                'status' => 200,
                'data' => [
                    'slug' => $slug,
                    'page' => $page,
                ]
            ];
        }
    }
}

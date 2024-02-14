<?php

namespace App\Http\Controllers\root;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::where('is_default', 1)
            ->where('status', 1)
            ->firstOrFail();
        return view('root.index', compact('page'));
    }
}

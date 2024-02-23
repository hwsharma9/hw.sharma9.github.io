<?php

namespace App\Http\Controllers\root;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Slider;
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
        $sliders = Slider::active()->get();
        return view('root.index', compact('page', 'sliders'));
    }
}

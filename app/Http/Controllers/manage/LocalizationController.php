<?php

namespace App\Http\Controllers\manage;

use App\Http\Controllers\Controller;

class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($locale)
    {
        if (!in_array($locale, array_keys(config('localization.locales')))) {
            abort(404);
        }

        session(['localization' => $locale]);

        return redirect()->back();
    }
}

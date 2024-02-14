<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileImageComposer
{
    protected $profile_image;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // Check if user is logged in
        if (Auth::check()) {
            // Check if user has uploaded a profile image
            if (
                isset(auth()->user()->upload->file_path)
                && Storage::disk('public')->exists(auth()->user()->upload->file_path)
            ) {
                // Set profile image if image in folder found
                $this->profile_image = asset(Storage::url(auth()->user()->upload->file_path));
            } else {
                // Set default profile image if image in folder not found
                $this->profile_image = asset('dist/img/profile-demo.png');
            }
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'profile_image' => $this->profile_image
        ]);
    }
}

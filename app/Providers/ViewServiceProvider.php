<?php

namespace App\Providers;

use App\View\Composers\AuthRoleComposer;
use App\View\Composers\MenuComposer;
use App\View\Composers\ProfileImageComposer;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthRoleComposer::class);
        $this->app->singleton(ProfileImageComposer::class);
        $this->app->singleton(MenuComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        // dd(auth('admin')->check());
        /**
         * AuthRoleComposer:class Provide model data of Admin's role and
         * there permissions.
         */
        View::composer('*', AuthRoleComposer::class);

        /**
         * ProfileImageComposer:class Provide user's profile image.
         */
        View::composer([
            'layouts.admin',
            'layouts.user',
            'admin.profile.profile'
        ], ProfileImageComposer::class);

        /**
         * MenuComposer:class Provide menu data.
         */
        View::composer(
            [
                'layouts.admin',
                'admin.admin_menus.index',
                'admin.roles.create',
                'admin.roles.edit'
            ],
            MenuComposer::class
        );
    }
}

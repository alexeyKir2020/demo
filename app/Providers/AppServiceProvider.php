<?php

namespace App\Providers;


use App\Models\Organisation;
use App\Models\User;
use App\Observers\OrganisationObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Organisation::observe(OrganisationObserver::class);
    }
}

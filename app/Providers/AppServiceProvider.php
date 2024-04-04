<?php

namespace App\Providers;

use App\Banner;
use App\Channel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('layouts.app', function ($view) {
            $channels = Channel::all();
            $banners = Banner::all();
            $view->with('channels', $channels)->with('banners', $banners);
        });

        View::composer('banners.index', function ($view) {
            $banners = Banner::all();
            $view->with('banners', $banners);
        });

        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}

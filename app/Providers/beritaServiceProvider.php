<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\post;
class beritaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $latest = post::orderBy('created_at','desc')->get();
        view()->share('latest', $latest);
    }
}

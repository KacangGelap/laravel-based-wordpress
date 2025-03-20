<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\post;
use Illuminate\Support\Facades\Schema;
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
       // Check if the posts table exists before querying
        if (Schema::hasTable('post')) {
            $latest = Post::orderBy('created_at', 'desc')->take(5)->get();
            view()->share('latest', $latest);

            $trending = Post::orderBy('pengunjung', 'desc')->take(5)->get();
            view()->share('trending', $trending);
            
        }
    }
}

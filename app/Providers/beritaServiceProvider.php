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
            $latest = Post::orderBy('created_at', 'desc')->get();
            view()->share('latest', $latest);

            $trending = Post::orderBy('pengunjung', 'desc')->get();
            view()->share('trending', $trending);
            $getBerita = \Request::has('post') ? Post::findOrFail(\Request::get('post')) : null;

            $title = $getBerita->judul ?? config('app.name');
            view()->share('title', $title);

            $description = \Str::limit($getBerita->deskripsi ?? '', 50);
            view()->share('description', $description);

            $image = $getBerita ? asset('storage/'.$getBerita->media1) : null;
            view()->share('image', $image);

            $url = config('app.url');
            view()->share('url', $url);

            $type = $getBerita ? 'berita' : 'uncategorized';
            view()->share('type', $type);
    
        }
    }
}

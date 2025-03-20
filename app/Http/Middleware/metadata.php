<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\models\post;
class metadata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current route name
        $routeName = \Route::current() ? \Route::current()->getName() : null;

        // Initialize metadata
        $metadata = [
            'title' => config('app.name'),
            'description' => '',
            'image' => null,
            'url' => config('app.url'),
            'type' => 'uncategorized',
        ];

        // Check if the route is 'post.view'
        if ($routeName === 'post.view' && $request->has('post')) {
            $getBerita = Post::find($request->get('post'));

            if ($getBerita) {
                $metadata = [
                    'title' => $getBerita->judul,
                    'description' => \Str::limit($getBerita->deskripsi ?? '', 50),
                    'image' => asset("storage/$getBerita->media1"),
                    'url' => config('app.url'),
                    'type' => 'berita',
                ];
            }
        }

        // Store metadata in the service container
        app()->singleton('metadata', fn() => $metadata);

        return $next($request);
    }
}

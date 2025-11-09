<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\halaman, App\models\post, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\subsubsubsubmenu;
use Illuminate\Support\Facades\URL;
class metadata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = \Route::current()?->getName();

        $metadata = [
            'title' => config('app.name'),
            'description' => '',
            'image' => null,
            'url' => URL::full(),
            'type' => 'website', // default
        ];

        if ($routeName === 'post.view' && $request->has('post')) {
            $post = Post::find($request->get('post'));
            if ($post) {
                $imagePath = $post->media1 ? "storage/{$post->media1}" : null;

                $metadata = [
                    'title' => $post->judul,
                    'description' => \Str::limit($post->deskripsi ?? '', 150),
                    'image' => $imagePath ? asset("storage/" . rawurlencode($post->media1)) : asset('storage/default-og.webp'),
                    'url' => request()->fullUrlWithQuery(['utp' => 'share']),
                    'type' => 'article',
                ];
            }
        } elseif ($routeName === 'page.show' && $request->has('id')) {
            $page = halaman::findOrFail($request->get('id'));
            $parent = subsubsubsubmenu::find($page->sub_sub_sub_sub_menu_id) 
                    ?? subsubsubmenu::find($page->sub_sub_sub_menu_id) 
                    ?? subsubmenu::find($page->sub_sub_menu_id) 
                    ?? submenu::find($page->sub_menu_id);

            if ($parent) {
                $metadata = [
                    'title' => $parent->sub_sub_sub_sub_menu ?? $parent->sub_sub_sub_menu ?? $parent->sub_sub_menu ?? $parent->sub_menu,
                    'description' => $page->text,
                    'image' => $page->media ? asset("storage/" . rawurlencode($page->media)) : asset('storage/default-og.webp'),
                    'url' => request()->fullUrlWithQuery(['utp' => 'share']),
                    'type' => 'page',
                ];
            }
        }

        app()->singleton('metadata', fn() => $metadata);

        return $next($request);
    }

}

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
        // Get the current route name
        $routeName = \Route::current() ? \Route::current()->getName() : null;

        // Initialize metadata
        $metadata = [
            'title' => config('app.name'),
            'description' => '',
            'image' => null,
            'url' => URL::full(),
            'type' => 'uncategorized',
        ];

        // Check if the route is 'post.view'
        if ($routeName === 'post.view' && $request->has('post')) {
            $getBerita = Post::find($request->get('post'));

            if ($getBerita) {
                $imagePath = "storage/" . $getBerita->media1;
                $imageUrl = asset($imagePath);

                // Get image dimensions (optional but good for OG)
                $width = $height = null;
                if (file_exists(public_path($imagePath))) {
                    [$width, $height] = getimagesize(public_path($imagePath));
                }

                $metadata = [
                    'title' => $getBerita->judul,
                    'description' => \Str::limit($getBerita->deskripsi ?? '', 150),
                    'image' => $imageUrl,
                    'image_width' => $width,
                    'image_height' => $height,
                    'url' => request()->fullUrlWithQuery(['utp' => 'share']),
                    'type' => 'article', 
                ];
            }
        }elseif($routeName === 'page.show' && $request->has('id')){
            $getPage = halaman::findOrFail($request->get('id'));
            $page = subsubsubsubmenu::find($getPage->sub_sub_sub_sub_menu_id) ?? subsubsubmenu::find($getPage->sub_sub_sub_menu_id) ?? subsubmenu::find($getPage->sub_sub_menu_id) ?? submenu::find($getPage->sub_menu_id);
            if($page){
                $metadata = [
                    'title' => $page->sub_sub_sub_sub_menu ?? $page->sub_sub_sub_menu ?? $page->sub_sub_menu ?? $page->sub_menu,
                    'description' => $page->text,
                    'image' => asset("storage/$page->media"),
                    'url' => request()->fullUrlWithQuery(['utp' => 'share']),
                    'type' => 'page',
                ];
            }
        }

        // Store metadata in the service container
        app()->singleton('metadata', fn() => $metadata);
        // dd($metadata);
        return $next($request);
    }
}

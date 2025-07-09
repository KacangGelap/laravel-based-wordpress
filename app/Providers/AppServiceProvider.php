<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\halaman, App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\subsubsubsubmenu, App\Models\layout, App\Models\link;
use App\Models\card;
use App\Models\advanced_carousel_category, App\Models\advanced_carousel;
use App\Models\page_embed_category, App\Models\page_embed;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('menus')) {
            $with = [];
    
            if (Schema::hasTable('sub_menus')) {
                $with[] = 'subMenus';
    
                if (Schema::hasTable('sub_sub_menus')) {
                    $with[] = 'subMenus.subSubMenus';
    
                    if (Schema::hasTable('sub_sub_sub_menus')) {
                        $with[] = 'subMenus.subSubMenus.subSubSubMenus';
    
                        if (Schema::hasTable('sub_sub_sub_sub_menus')) {
                            $with[] = 'subMenus.subSubMenus.subSubSubMenus.subSubSubSubMenus';
                        }
                    }
                }
            }
    
            // Only eager-load available relationships
            $menus = !empty($with)
                ? Menu::with($with)->get()
                : Menu::all();
    
            view()->share('menus', $menus);
        }
    
        if (Schema::hasTable('link')) {
            $link_terkait = link::limit(5)->get();
            view()->share('link_terkait', $link_terkait);
        }
    
        if (Schema::hasTable('layout')) {
            $carousel = layout::where('type', '!=', 'banner')->get();
            $banner = layout::where('type', 'banner')->first();
            view()->share('banner', $banner);
            view()->share('carousel', $carousel);
        }
        if (Schema::hasTable('card')){
            $card = card::all();
            view()->share('card', $card);
        }
        if (Schema::hasTable('advanced_carousel_category') && Schema::hasTable('advanced_carousel')){
            $advanced_cat = advanced_carousel_category::with('carousels')->get();
            view()->share('advanced_cat', $advanced_cat);
        }
        if (Schema::hasTable('page_embed_category') && Schema::hasTable('page_embed')) {
            $selfHost = parse_url(url('/'), PHP_URL_HOST);

            $page_embed_cat = page_embed_category::with('embeds')->get();

            foreach ($page_embed_cat as $cat) {
                // Filter & parsing valid embed
                $validEmbeds = $cat->embeds->map(function ($embed) use ($selfHost) {
                    $parsedUrl = parse_url($embed->link);
                    $host = $parsedUrl['host'] ?? null;
                    $path = $parsedUrl['path'] ?? null;

                    if ($host !== $selfHost || $path !== '/page') return null;

                    parse_str($parsedUrl['query'] ?? '', $queryParams);
                    $halamanId = $queryParams['id'] ?? null;
                    if (!$halamanId) return null;

                    $halaman = halaman::find($halamanId);
                    if (!$halaman) return null;

                    $embed->halaman = $halaman;
                    $embed->currentpage =
                        subsubsubsubmenu::find($halaman->sub_sub_sub_sub_menu_id) ??
                        subsubsubmenu::find($halaman->sub_sub_sub_menu_id) ??
                        subsubmenu::find($halaman->sub_sub_menu_id) ??
                        submenu::find($halaman->sub_menu_id);

                    return $embed;
                })->filter()->values(); // Bersihkan null & reset index

                // Manual paginate 5 item per kategori
                $page = request()->input("page_{$cat->id}", 1);
                $perPage = 5;
                $offset = ($page - 1) * $perPage;

                $cat->paginated_valid_embeds = new LengthAwarePaginator(
                    $validEmbeds->slice($offset, $perPage)->values(),
                    $validEmbeds->count(),
                    $perPage,
                    $page,
                    [
                        'pageName' => "page_{$cat->id}",
                        'path' => request()->url(),
                        'query' => request()->query(),
                    ]
                );
            }
            // dd($page_embed_cat);
            view()->share('embeds', $page_embed_cat);
        }

        if(\Storage::exists('profil.txt')){
            $video_profile = \Storage::get('profil.txt');
            view()->share('video_profile', $video_profile);
        }
        if(\Storage::exists('quote.txt')){
            $quote = \Storage::get('quote.txt');
            view()->share('quote', $quote);
        }
        if (
            Schema::hasTable('sub_menus') &&
            Schema::hasTable('sub_sub_menus') &&
            Schema::hasTable('sub_sub_sub_menus') &&
            Schema::hasTable('sub_sub_sub_sub_menus')
        ) {
            $master = submenu::where('type', 'id.pdupt')->first()
                ?? subsubmenu::where('type', 'id.pdupt')->first()
                ?? subsubsubmenu::where('type', 'id.pdupt')->first()
                ?? subsubsubsubmenu::where('type', 'id.pdupt')->first();
    
            view()->share('master', $master);
        }
    }    
}

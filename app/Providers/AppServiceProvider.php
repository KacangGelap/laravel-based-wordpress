<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\subsubsubsubmenu, App\Models\layout, App\Models\link;
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

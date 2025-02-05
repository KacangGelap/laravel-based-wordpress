<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu, App\Models\layout, App\Models\link;
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
        
        // Check if the menus table exists before querying
        if (Schema::hasTable('menus')) {
            // Fetch the menus with eager loading of subMenus and subSubMenus
            $menus = Menu::with('subMenus.subSubMenus.subSubSubMenus')->get();
            // Share the menus variable with all views
            view()->share('menus', $menus);
        }
        if (Schema::hasTable('link')){
            $link_terkait = link::all();
            view()->share('link_terkait', $link_terkait);
        }
        if (Schema::hasTable('layout')) {
            // Fetch the menus with eager loading of subMenus and subSubMenus
            $carousel = layout::where('type', '!=', 'banner')->get();
            $banner = layout::where('type', 'banner')->first();
            // Share the menus variable with all views
            view()->share('banner', $banner);
            view()->share('carousel', $carousel);
        }
        // Check if submenus, subsubmenus, and subsubsubmenus tables exist before querying
        if (Schema::hasTable('sub_menus') && Schema::hasTable('sub_sub_menus') && Schema::hasTable('sub_sub_sub_menus')) {
            // Fetch master data across all of the menu table
            $master = submenu::where('type', 'id.pdupt')->first() ??
                    subsubmenu::where('type', 'id.pdupt')->first() ??
                    subsubsubmenu::where('type', 'id.pdupt')->first();

            view()->share('master', $master);
        }
    }
}

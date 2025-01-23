<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu, App\Models\subsubsubmenu;
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
        // Fetch the menus with eager loading of subMenus and subSubMenus
        $menus = Menu::with('subMenus.subSubMenus.subSubSubMenus')->get();
        // Share the menus variable with all views
        view()->share('menus', $menus);
        // Fetch master data across all of the menu table
        $master = submenu::where('type', 'id.pdupt')->first() ?? subsubmenu::where('type', 'id.pdupt')->first() ?? subsubsubmenu::where('type','id.pdupt')->first();
        view()->share('master', $master);
    }
}

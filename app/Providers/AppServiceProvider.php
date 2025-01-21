<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\menu, App\Models\submenu, App\Models\subsubmenu;
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
    }
}

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
        // \DB::enableQueryLog();
        // $menus = menu::with('subMenus.subSubMenus',)->get();
        // dd(\DB::getQueryLog());

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

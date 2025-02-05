<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\statistic;
use Illuminate\Support\Facades\Schema;
class StatisticServiceProvider extends ServiceProvider
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
        // Fetch today's date
      $today = now()->toDateString();

      // Check if the statistics table exists before querying
        if (Schema::hasTable('statistics')) {
            // Get today's statistics
            $todayStats = Statistic::where('date', $today)->first();
            $totalStats = Statistic::selectRaw('SUM(visitors) as total_visitors, SUM(page_views) as total_page_views')->first();

            // Share data with all views
            View::share('today_visitors', $todayStats->visitors ?? 0);
            View::share('today_page_views', $todayStats->page_views ?? 0);
            View::share('total_visitors', $totalStats->total_visitors ?? 0);
            View::share('total_page_views', $totalStats->total_page_views ?? 0);
        } else {
            // Default values if the table doesn't exist
            View::share('today_visitors', 0);
            View::share('today_page_views', 0);
            View::share('total_visitors', 0);
            View::share('total_page_views', 0);
        }
    }
}

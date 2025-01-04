<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\statistic;

class visitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $date = now()->toDateString();
        
        $statistic = statistic::firstOrCreate(['date' => $date]);

        $statistic->increment('page_views');

        if (!$request->session()->has('visitor_counted')) {
            $statistic->increment('visitors');
            $request->session()->put('visitor_counted', true);
        }

        return $next($request);
    }
}

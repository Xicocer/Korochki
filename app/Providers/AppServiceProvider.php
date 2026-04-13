<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('web-global', function (Request $request) {
            $ip = $request->ip() ?? 'unknown';
            $routeKey = $request->path() ?: '/';

            return [
                Limit::perMinute(180)
                    ->by("ip:{$ip}")
                    ->response(function () {
                        return response('Слишком много запросов. Повторите немного позже.', 429);
                    }),

                Limit::perMinute(90)
                    ->by("route:{$ip}|{$routeKey}")
                    ->response(function () {
                        return response('Слишком много запросов к странице. Повторите немного позже.', 429);
                    }),
            ];
        });
    }
}

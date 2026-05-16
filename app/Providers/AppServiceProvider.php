<?php

namespace App\Providers;

use App\Services\Analytics\AnalyticsDataClient;
use App\Services\Analytics\GoogleAnalyticsDataClient;
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
        $this->app->bind(AnalyticsDataClient::class, GoogleAnalyticsDataClient::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('analytics', function (Request $request): Limit {
            return Limit::perMinute(60)->by($request->ip());
        });

        RateLimiter::for('analytics-export', function (Request $request): Limit {
            return Limit::perMinute(12)->by($request->ip());
        });
    }
}

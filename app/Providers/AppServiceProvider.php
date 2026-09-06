<?php

namespace App\Providers;

use App\Services\Analytics\AnalyticsDataClient;
use App\Services\Analytics\GoogleAnalyticsDataClient;
use App\Support\RegistrationTypes;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        Relation::enforceMorphMap(RegistrationTypes::TYPE_MODELS);

        RateLimiter::for('analytics', function (Request $request): Limit {
            return Limit::perMinute(60)->by($request->ip());
        });

        RateLimiter::for('analytics-export', function (Request $request): Limit {
            return Limit::perMinute(12)->by($request->ip());
        });
    }
}

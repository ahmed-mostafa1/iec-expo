<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');

        if (! in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        view()->share('currentLocale', $locale);
        view()->share('dir', $locale === 'ar' ? 'rtl' : 'ltr');

        return $next($request);
    }
}

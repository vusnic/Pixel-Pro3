<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Always prioritize the env APP_LOCALE setting for web interfaces
        if (!$request->wantsJson() && !$request->is('api/*')) {
            App::setLocale(config('app.locale'));
            return $next($request);
        }
        
        // For API requests, check header or parameter
        $locale = $request->header('Accept-Language') ?? $request->input('locale') ?? config('app.locale');
        
        // Make sure locale is in supported locales
        $locale = in_array($locale, config('app.available_locales', ['en'])) ? $locale : config('app.locale');
        
        App::setLocale($locale);
        
        return $next($request);
    }
} 
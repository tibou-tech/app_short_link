<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $locale = $request->segment(1);

        // If url contains locale
        if (array_key_exists($locale, config('app.locales'))) {
            $this->setLocale($locale);

            return $next($request);
        }

        // If request
        if ($request->query('locale')) {
            $this->setLocale($request->query('locale'));

            return $next($request);
        }

        // If user is authenticated
        if (Auth::user()) {
            $this->setLocale(Auth::user()->locale);

            return $next($request);
        }

        if (session('locale')) {
            app()->setLocale(session('locale'));

            return $next($request);
        }

        return $next($request);
    }

    private function setLocale(string $locale)
    {
        session(['locale' => $locale]);

        app()->setLocale($locale);

        Carbon::setLocale($locale);
    }
}

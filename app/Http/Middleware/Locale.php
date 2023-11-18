<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Config;
use Illuminate\Http\Request;
use Session;

class Locale
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
        $language = Session::get('locale', Config::get('app.locale'));

        App::setLocale($language);

        return $next($request);
    }
}

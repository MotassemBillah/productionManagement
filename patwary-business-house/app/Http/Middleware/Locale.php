<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App;
use Config;

class Locale {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $language = !empty(Auth::user()) ? Auth::user()->locale : App::getLocale();
        App::setLocale($language);
        return $next($request);
    }

}

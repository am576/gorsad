<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \LaravelFeature\Facade\Feature;

class FeatureEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $feature)
    {
        if(Feature::isEnabled($feature)) {
            return $next($request);
        }
        return abort(404);;
    }
}

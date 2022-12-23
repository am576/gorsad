<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserOwnsOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset($request->id))
        {
            $order_id = ltrim($request->id, '0');
            if (!Auth::user()->orders()->find($order_id)) abort(403);
        }

        return $next($request);
    }
}

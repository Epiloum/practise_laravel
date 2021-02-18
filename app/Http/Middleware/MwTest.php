<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MwTest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->value > 200)
        {
            return redirect('err');
        }

        return $next($request);
    }
}

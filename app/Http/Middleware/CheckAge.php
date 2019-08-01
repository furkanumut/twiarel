<?php

namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $ageLimit = 18)
    {
        if($request->user()->age < $ageLimit):
            return redirect()->route("sadecekucukler")->with("status",__('Yaşın tutmuyor Aslanım'));
        endif;
        return $next($request);
    }
}

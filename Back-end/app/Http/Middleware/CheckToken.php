<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     //checa o token passado pelo usuario
    public function handle($request, Closure $next)
    {
        if(!$user = JWTAuth::parseToken()->authenticate()){
          return response()->json(['message'=>'User not found']);
        }
        return $next($request);
    }
}

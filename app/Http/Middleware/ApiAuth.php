<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ApiAuth
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
        $token = $request->header('token');

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'message'=> 'you need authorization'
            ], 403);
        }

        return $next($request);
    }
}

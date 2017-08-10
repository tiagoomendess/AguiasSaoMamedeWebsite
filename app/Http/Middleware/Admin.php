<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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

        //verificar se está autenticado
        if(Auth::check()) {

            $user = Auth::user();

            //verificar se tem permissões
            if ($user->perm_level > 1)
                return $next($request);
            else
                return abort(404);
        } else {
            return abort(404);
        }

        return $next($request);
    }
}

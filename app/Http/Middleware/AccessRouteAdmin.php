<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;

class AccessRouteAdmin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($this->auth->user());
        if ($this->auth->user()->rol != 1) 
        {
            Session::flash('message_error', 'Su cuenta de usuario no posee los permisos para acceder al contenido solicitado!');

            return redirect()->to('acceso/restringido');
        }
        return $next($request);
    }
}

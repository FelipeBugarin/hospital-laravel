<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário logado tem o ID 1
        if (auth()->check() && auth()->id() === 1) {
            return $next($request);
        }

        // Se não for você, redireciona para o dashboard com erro
        return redirect('/dashboard')->with('erro', 'Acesso restrito apenas para administradores.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        
        // 1. Verifica se o usuário está logado E se a sua role é 'admin'
        if (auth()->check() && auth()->user()->role == 'admin') {
            // 2. Se for admin, permite que a requisição continue
            return $next($request);
        }

        // 3. Se não for admin, bloqueia o acesso com um erro 403 (Acesso Proibido)
        abort(403, 'Acesso Não Autorizado.');
    }
}
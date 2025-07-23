<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class VendedorScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        // Verifica se há um usuário logado e se ele é um vendedor
        if (Auth::check() && auth()->user()->isVendedor()) {
            // Se for vendedor, adiciona um 'WHERE' para filtrar
            // os clientes que pertencem (user_id) a ele.
            $builder->where('user_id', auth()->id());
        }
        // Se o usuário for admin, ou se não houver ninguém logado,
        // nenhuma condição é adicionada, e a consulta retornará TUDO.
    }
}
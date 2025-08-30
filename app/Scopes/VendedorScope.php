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
    
        if (Auth::check() && auth()->user()->isVendedor()) {

            $builder->where('user_id', auth()->id());
        }
    
    }
}

//funcao p ver qual cliente tem qual vendedor e se for adm mostrar tds os clientes c o respectivo vendedor
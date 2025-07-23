<?php

namespace App\Models;

use App\Models\User; 
use App\Scopes\VendedorScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientesPagantes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor_contrato',
        'UC_existente',
        'user_id',
    ];

    /**
     * Define a relação: Este cliente pertence a um usuário.
     */
   protected static function booted(): void
    {
        static::addGlobalScope(new VendedorScope);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
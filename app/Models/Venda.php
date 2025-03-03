<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';
    protected $fillable = ['cliente_id', 'valor', 'qtnd_parcelas'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($venda) {
            $venda->parcelas()->delete();
            $venda->produtos()->detach();
        });
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    public function produtos() {
        return $this->belongsToMany(Produto::class, 'itens_vendas')
                    ->withPivot('quantidade');
    }

    public function parcelas() {
        return $this->hasMany(Parcela::class);
    }
}

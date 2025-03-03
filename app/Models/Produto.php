<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $fillable = ['nome', 'estoque', 'valor'];

    public function vendas() {
        return $this->belongsToMany(Venda::class, 'itens_vendas')
                    ->withPivot('quantidade');
    }
}

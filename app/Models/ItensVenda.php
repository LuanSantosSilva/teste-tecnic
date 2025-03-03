<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItensVenda extends Model
{
    protected $table = 'itens_vendas';
    protected $fillable = ['venda_id', 'produto_id', 'quantidade'];
}

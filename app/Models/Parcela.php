<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $table = 'parcelas';
    protected $fillable = ['venda_id', 'valor', 'vencimento', 'numero'];

    public function venda() {
        return $this->belongsTo(Venda::class);
    }
}

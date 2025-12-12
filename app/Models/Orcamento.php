<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $table = "orcamento";
    protected $fillable = [
        "categoria",
        "descricao",
        "valor_previsto",
        "valor_realizado",
        "tipo",
    ];
}

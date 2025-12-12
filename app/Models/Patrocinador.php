<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patrocinador extends Model
{

    protected $table = "patrocinadores";
    protected $fillable = [
        'nome',
        'contato_nome',
        'contato_email',
        'contato_telefone',
        'valor_patrocinio',
        'status',
        'observacoes',
    ];
}

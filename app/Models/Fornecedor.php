<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    
    protected $fillable = [
        'nome',
        'tipo',
        'contato_telefone',
        'contato_email',
        'contato_nome',
        'valor_orcamento',
        'status',
        'observacoes'
    ];
}

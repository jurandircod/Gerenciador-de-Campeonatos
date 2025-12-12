<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competidor extends Model
{
    protected $table = 'competidores';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'categoria',
        'status_inscricao',
        'cidade',
        'estado',
    ];
}

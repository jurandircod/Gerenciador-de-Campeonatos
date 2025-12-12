<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'responsavel_id',
        'area_id',
        'prazo',
        'prioridade',
        'status',
    ];

    public function responsavel()
    {
        return $this->belongsTo(Responsavel::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
}

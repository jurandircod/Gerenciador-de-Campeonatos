<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $fillable = ['nome', 'descricao', 'responsavel_id'];

    public function responsavel(){
        return $this->belongsTo(Responsavel::class);
    }
}

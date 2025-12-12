<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    protected $table = 'responsaveis';
    protected $fillable = ['nome', 'email', 'telefone', 'area_responsabilidade'];    

    public function areas(){
        return $this->hasMany(Area::class);
    }
}

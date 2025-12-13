<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juiz extends Model
{
    protected $table = 'juizes';
    
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'experiencia',
        'status'
    ];

}

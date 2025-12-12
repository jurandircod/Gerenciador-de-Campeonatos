<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class juiz extends Model
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

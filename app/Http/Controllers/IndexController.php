<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{Responsavel, Area, Tarefa, Juiz, Fornecedor, Patrocinador, Orcamento};

class IndexController extends Controller
{
    public function index()
    {
        $responsaveis = Responsavel::all();
        $areas = Area::all();
        $tarefas = Tarefa::all();
        $juizes = Juiz::all();
        $fornecedores = Fornecedor::all();
        $patrocinadores = Patrocinador::all();
        $orcamentos = Orcamento::all();

        return view('index', compact('responsaveis', 'areas', 'tarefas', 'juizes', 'fornecedores', 'patrocinadores', 'orcamentos'));
    }
}

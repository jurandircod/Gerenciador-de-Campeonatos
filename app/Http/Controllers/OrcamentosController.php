<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Orcamento;

class OrcamentosController extends Controller
{
    public function index()
    {
        $orcamentos = Orcamento::all();
        return view('orcamento', compact('orcamentos'));
    }

    public function store(Request $request)
    {
        $orcamento = Orcamento::create($request->all());
        return redirect()->route('orcamentos.index');
    }
}

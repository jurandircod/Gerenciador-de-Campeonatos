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
        return redirect()->route('orcamentos.index')->with('success', 'Item orçamentário criado com sucesso!');
    }

    public function edit($id)
    {
        $orcamento = Orcamento::find($id);
        $inputs = $orcamento->toArray();
        $orcamentos = Orcamento::all();
        return view('orcamento', compact('inputs', 'orcamentos'))->with('message', 'atualize os dados do item orçamentário');
    }

    public function update(Request $request)
    {
        $orcamento = Orcamento::find($request->id);
        $orcamento->update($request->all());
        return redirect()->route('orcamentos.index')->with('success', 'Item orçamentário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $orcamento = Orcamento::find($id);
        $orcamento->delete();
        return redirect()->route('orcamentos.index')->with('success', 'Item orçamentário excluído com sucesso!');
    }
}

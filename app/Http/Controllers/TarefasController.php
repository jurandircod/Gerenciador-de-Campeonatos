<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsavel;
use App\Models\Area;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Validator;

class TarefasController extends Controller
{
    public function index()
    {
        $tarefas = Tarefa::all();
        $responsaveis = Responsavel::all();
        $areas = Area::all();
        return view('tarefas', compact('responsaveis', 'areas', 'tarefas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'responsavel_id' => 'required|exists:responsaveis,id',
            'area_id' => 'required|exists:areas,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'prazo' => 'required|date',
            'status' => 'required|in:Pendente,Em Andamento,Concluída',
            'prioridade' => 'required|in:Alta,Média,Baixa',
        ], [
            'responsavel_id.required' => 'O campo responsável é obrigatório.',
            'responsavel_id.exists' => 'Responsável inválido.',
            'area_id.required' => 'O campo área é obrigatório.',
            'area_id.exists' => 'Área inválida.',
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.max' => 'O campo título deve ter no máximo 255 caracteres.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'prazo.required' => 'O campo prazo é obrigatório.',
            'prazo.date' => 'O campo prazo deve ser uma data válida.',
            'status.required' => 'O campo status é obrigatório.',
            'status.in' => 'Status inválido.',
            'prioridade.required' => 'O campo prioridade é obrigatório.',
            'prioridade.in' => 'Prioridade inválida.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Tarefa::create($request->all());

        return redirect()->route('tarefas.index')
            ->with('success', 'Tarefa cadastrada com sucesso!');
    }

    public function destroy($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->delete();
        return back()->with('success', 'Tarefa excluída com sucesso!');
    }

    public function edit($id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $inputs = $tarefa->toArray();
        $responsaveis = Responsavel::all();
        $areas = Area::all();
        $tarefas = Tarefa::all();
        return view('tarefas', compact('inputs', 'responsaveis', 'areas', 'tarefas'));
    }

    public function update(Request $request, $id)
    {
        $tarefa = Tarefa::findOrFail($id);
        $tarefa->update($request->all());
        return back()->with('success', 'Tarefa atualizada com sucesso!');
    }
}

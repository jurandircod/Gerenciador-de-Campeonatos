<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsavel;
use Illuminate\Support\Facades\Validator;

class ResponsaveisController extends Controller
{
    public function index()
    {
        $responsaveis = Responsavel::all();
        return view('responsaveis.index', compact('responsaveis'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:responsaveis,email',
            'telefone' => 'required|string|max:20',
            'area_responsabilidade' => 'required|string|max:500'
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'telefone.required' => 'O campo telefone é obrigatório.',
            'area_responsabilidade.required' => 'O campo área de responsabilidade é obrigatório.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Responsavel::create($request->all());

        return redirect()->route('responsaveis.index')
            ->with('success', 'Responsável cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $responsavel = Responsavel::findOrFail($id);
        $responsavel->delete();
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $responsavel = Responsavel::findOrFail($id);
        $inputs = $responsavel->toArray();
        $responsaveis = Responsavel::all();

        return view('responsavel', compact('inputs', 'responsaveis'));
    }

    public function update(Request $request, $id)
    {
        $responsavel = Responsavel::findOrFail($id);
        $responsavel->update($request->all());
        return redirect()->route('responsaveis.index')
            ->with('success', 'Responsável atualizado com sucesso!');
    }

    public function getResponsaveis()
    {
        $responsaveis = Responsavel::all();
        return response()->json($responsaveis);
    }
}
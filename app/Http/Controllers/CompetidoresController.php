<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Competidor;

class CompetidoresController extends Controller
{
    public function index()
    {
        $competidores = Competidor::all();
        return view('competidor', compact('competidores'));
    }

    public function store(Request $request)
    {
        $competidor = Competidor::create($request->all());
        return redirect()->route('competidores.index')->with('success', 'Competidor criado com sucesso!');
    }

    public function edit($id){
        $competidores = Competidor::find($id);
        $inputs = $competidores->toArray();
        $competidores = Competidor::all();
        return view('competidor', compact('inputs', 'competidores'));
    }

    public function update(Request $request){
        $competidores = Competidor::find($request->id);
        $competidores->update($request->all());
        return redirect()->route('competidores.index')->with('success', 'Competidor atualizado com sucesso!');
    }

    public function destroy($id){
        $competidores = Competidor::find($id);
        $competidores->delete();
        return redirect()->route('competidores.index')->with('success', 'Competidor excluído com sucesso!');
    }
}

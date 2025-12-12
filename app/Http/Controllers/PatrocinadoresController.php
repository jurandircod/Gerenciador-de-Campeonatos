<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Patrocinador;

class PatrocinadoresController extends Controller
{
    public function index()
    {
        $patrocinadores = Patrocinador::all();
        return view('patrocinador', compact('patrocinadores'));
    }

    public function store(Request $request)
    {
        Patrocinador::create($request->all());
        return redirect()->route('patrocinadores.index')->with('success', 'Patrocinador cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $patrocinador = Patrocinador::findOrFail($id);
        $patrocinador->delete();
        return redirect()->route('patrocinadores.index')->with('success', 'Patrocinador cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $patrocinador = Patrocinador::findOrFail($id);
        $patrocinadores = Patrocinador::all();
        $inputs = $patrocinador->toArray();
        return view('patrocinador', compact('inputs', 'patrocinadores'));
    }

    public function update(Request $request, $id)
    {
        $patrocinador = Patrocinador::findOrFail($id);
        $patrocinador->update($request->all());
        return redirect()->route('patrocinadores.index')->with('success', 'Patrocinador atualizado com sucesso!');
    }
}

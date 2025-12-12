<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Responsavel;
use App\Models\Area;

class AreasController extends Controller
{
    public function index(){
        $responsaveis = Responsavel::all();
        $areas = Area::all(); 
        return view('area', compact('responsaveis', 'areas'));
    }

    public function store(Request $request){
        $area = Area::create($request->all());
        if($area){
            return redirect()->route('areas.index')->with('success', 'Area cadastrada com sucesso!');
        }else{
            return redirect()->route('areas.index')->with('error', 'Erro ao cadastrar area!');
        }
    }

    public function destroy(Request $request){
        $area = Area::findOrFail($request->id);
        if($area){
            $area->delete();
            return redirect()->route('areas.index')->with('success', 'Area excluida com sucesso!');
        }else{
            return redirect()->route('areas.index')->with('error', 'Erro ao excluir area!');
        }
    }

    public function edit($id){
        $area = Area::findOrFail($id);
        $responsaveis = Responsavel::all();
        $areas = Area::all(); 

        $inputs = [
            'id' => $area->id,
            'nome' => $area->nome,
            'descricao' => $area->descricao,
            'responsavel_id' => $area->responsavel_id
        ];  
        return view('area', compact('responsaveis', 'inputs','areas'));
    }

    public function update(Request $request){
        $area = Area::findOrFail($request->id);
        $area->update($request->all());
        if($area){
            return redirect()->route('areas.index')->with('success', 'Area atualizada com sucesso!');
        }else{
            return redirect()->route('areas.index')->with('error', 'Erro ao atualizar area!');
        }
    }
}

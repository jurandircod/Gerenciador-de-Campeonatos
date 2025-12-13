<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Juiz;

class JuizesController extends Controller
{
    public function index()
    {
        $juizes = Juiz::all();
        return view('juiz', compact('juizes'));
    }

    public function store(Request $request)
    {
        $juizes = Juiz::all();
        $juiz = Juiz::create($request->all());
        return redirect()->route('juizes.index', compact('juizes'))->with('success', 'Juiz cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $juiz = Juiz::find($id);
        $juiz->delete();
        return redirect()->route('juizes.index')->with('success', 'Juiz excluído com sucesso!');
    }

    public function edit($id)
    {
        $juiz = Juiz::find($id);
        $inputs = $juiz->toArray();
        $juizes = Juiz::all();
        return view('juiz', compact('inputs', 'juizes'));
    }

    public function update(Request $request)
    {
        $juiz = Juiz::find($request->id);
        $juiz->update($request->all());
        return redirect()->route('juizes.index')->with('success', 'Juiz excluído com sucesso!');

    }
}

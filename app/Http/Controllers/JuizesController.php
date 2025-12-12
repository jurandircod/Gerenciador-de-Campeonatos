<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\juiz;

class JuizesController extends Controller
{
    public function index()
    {
        $juizes = juiz::all();
        return view('juiz', compact('juizes'));
    }

    public function store(Request $request)
    {
        $juizes = juiz::all();
        $juiz = juiz::create($request->all());
        return redirect()->route('juizes.index', compact('juizes'))->with('success', 'Juiz cadastrado com sucesso!');
    }

    public function destroy($id)
    {
        $juiz = juiz::find($id);
        $juiz->delete();
        return redirect()->route('juizes.index')->with('success', 'Juiz excluído com sucesso!');
    }

    public function edit($id)
    {
        $juiz = juiz::find($id);
        $inputs = $juiz->toArray();
        $juizes = juiz::all();
        return view('juiz', compact('inputs', 'juizes'));
    }

    public function update(Request $request)
    {
        $juiz = juiz::find($request->id);
        $juiz->update($request->all());
        return redirect()->route('juizes.index')->with('success', 'Juiz excluído com sucesso!');

    }
}

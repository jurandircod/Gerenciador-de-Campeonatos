<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Fornecedor;

class FornecedoresController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedor', compact('fornecedores'));
    }

    public function store(Request $request)
    {
        $fornecedor = Fornecedor::create($request->all());
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso');
    }

    public function edit($id)
    {
        $fornecedor = Fornecedor::find($id);
        $inputs = $fornecedor->toArray();
        $fornecedores = Fornecedor::all();
        return view('fornecedor', compact('inputs', 'fornecedores'));
    }

    public function update(Request $request)
    {
        $fornecedor = Fornecedor::find($request->id);
        $fornecedor->update($request->all());
        return redirect()->route('fornecedores.index');
    }

    public function destroy($id)
    {
        $fornecedor = Fornecedor::find($id);
        $fornecedor->delete();
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluído com sucesso');
    }
}

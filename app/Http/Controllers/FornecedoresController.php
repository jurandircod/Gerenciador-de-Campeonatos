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
        return redirect()->route('fornecedores.index');
    }
}

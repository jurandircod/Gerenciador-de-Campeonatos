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
        $juiz = juiz::create($request->all());
        return redirect()->route('juizes.index');
    }
}

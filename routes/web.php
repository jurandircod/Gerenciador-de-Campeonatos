<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\ResponsaveisController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\TarefasController;
use App\Http\Controllers\PatrocinadoresController;
use App\Http\Controllers\JuizesController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\OrcamentosController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CompetidoresController;


Route::get('/', [IndexController::class, 'index'])->name('home');


Route::get('/api/responsaveis', [ResponsaveisController::class, 'getResponsaveis']);
Route::post('/responsaveis/{id}', [ResponsaveisController::class, 'destroy'])->name('responsaveis.destroy');
Route::get('/responsaveis/{id}/edit', [ResponsaveisController::class, 'edit'])->name('responsaveis.edit');
Route::post('/responsaveis/{id}/update', [ResponsaveisController::class, 'update'])->name('responsaveis.update');


Route::group(['prefix' => 'competidores'], function () {
    Route::get('/', [CompetidoresController::class, 'index'])->name('competidores.index');
    Route::post('/create', [CompetidoresController::class, 'store'])->name('competidores.store');
    Route::post('/delete/{id}', [CompetidoresController::class, 'destroy'])->name('competidores.destroy');
    Route::get('/edit/{id}', [CompetidoresController::class, 'edit'])->name('competidores.edit');
    Route::post('/update', [CompetidoresController::class, 'update'])->name('competidores.update');
});

Route::group(['prefix' => 'areas'], function () {
    Route::get('/', [AreasController::class, 'index'])->name('areas.index');
    Route::post('/create', [AreasController::class, 'store'])->name('areas.store');
    Route::post('/delete', [AreasController::class, 'destroy'])->name('areas.destroy');
    Route::get('/edit/{id}', [AreasController::class, 'edit'])->name('areas.edit');
    Route::post('/update', [AreasController::class, 'update'])->name('areas.update');
});
Route::group(['prefix' => 'fornecedores'], function () {
    Route::get('/', [FornecedoresController::class, 'index'])->name('fornecedores.index');
    Route::post('/create', [FornecedoresController::class, 'store'])->name('fornecedores.store');
    Route::post('/delete/{id}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');
    Route::get('/edit/{id}', [FornecedoresController::class, 'edit'])->name('fornecedores.edit');
    Route::post('/update', [FornecedoresController::class, 'update'])->name('fornecedores.update');
});
Route::group(['prefix' => 'patrocinadores'], function () {
    Route::get('/', [PatrocinadoresController::class, 'index'])->name('patrocinadores.index');
    Route::post('/create', [PatrocinadoresController::class, 'store'])->name('patrocinadores.store');
    Route::post('/delete/{id}', [PatrocinadoresController::class, 'destroy'])->name('patrocinadores.destroy');
    Route::get('/edit/{id}', [PatrocinadoresController::class, 'edit'])->name('patrocinadores.edit');
    Route::post('/update/{id}', [PatrocinadoresController::class, 'update'])->name('patrocinadores.update');
});
Route::group(['prefix' => 'orcamentos'], function () {
    Route::get('/', [OrcamentosController::class, 'index'])->name('orcamentos.index');
    Route::post('/create', [OrcamentosController::class, 'store'])->name('orcamentos.store');
    Route::post('/delete/{id}', [OrcamentosController::class, 'destroy'])->name('orcamentos.destroy');
    Route::get('/edit/{id}', [OrcamentosController::class, 'edit'])->name('orcamentos.edit');
    Route::post('/update', [OrcamentosController::class, 'update'])->name('orcamentos.update');
});

Route::group(['prefix' => 'juizes'], function () {
    Route::get('/', [JuizesController::class, 'index'])->name('juizes.index');
    Route::post('/create', [JuizesController::class, 'store'])->name('juizes.store');
    Route::post('/delete/{id}', [JuizesController::class, 'destroy'])->name('juizes.destroy');
    Route::get('/edit/{id}', [JuizesController::class, 'edit'])->name('juizes.edit');
    Route::post('/update', [JuizesController::class, 'update'])->name('juizes.update');
});
Route::group(['prefix' => 'tarefas'], function () {
    Route::get('/', [TarefasController::class, 'index'])->name('tarefas.index');
    Route::post('/create', [TarefasController::class, 'store'])->name('tarefas.store');
    Route::post('/delete/{id}', [TarefasController::class, 'destroy'])->name('tarefas.destroy');
    Route::get('/edit/{id}', [TarefasController::class, 'edit'])->name('tarefas.edit');
    Route::post('/update/{id}', [TarefasController::class, 'update'])->name('tarefas.update');
});

Route::group(['prefix' => 'responsaveis'], function () {
    Route::get('/', function () {
        return view('responsavel');
    })->name('responsaveis.create');

    Route::get('/', function () {
        return view('responsavel');
    })->name('responsaveis.index');
    Route::post('/', [ResponsaveisController::class, 'store'])->name('responsaveis.store');
});

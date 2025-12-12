<?php
use App\Http\Controllers\ResponsaveisController;

Route::get('/responsaveis', [ResponsaveisController::class, 'getResponsaveis']);

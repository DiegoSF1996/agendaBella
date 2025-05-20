<?php

use App\Http\Middleware\CheckAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('servicos', App\Http\Controllers\ServicoController::class)->middleware([CheckAuth::class])->parameters(['servicos' => 'id']);
Route::apiResource('pessoa-fisicas', App\Http\Controllers\PessoaFisicaController::class)->middleware([CheckAuth::class])->parameters(['pessoa-fisicas' => 'id']);
Route::apiResource('pessoa-juridicas', App\Http\Controllers\PessoaJuridicaController::class)->middleware([CheckAuth::class])->parameters(['pessoa-juridicas' => 'id']);
Route::apiResource('pessoa-juridicas', App\Http\Controllers\PessoaJuridicaController::class)->middleware([CheckAuth::class])->parameters(['pessoa-juridicas' => 'id']);
Route::apiResource('status-agendamentos', App\Http\Controllers\StatusAgendamentoController::class)->middleware([CheckAuth::class])->parameters(['status-agendamentos' => 'id']);
Route::apiResource('agendamentos', App\Http\Controllers\AgendamentoController::class)->middleware([CheckAuth::class])->parameters(['agendamentos' => 'id']);
Route::apiResource('avaliacao-agendamentos', App\Http\Controllers\AvaliacaoAgendamentoController::class)->middleware([CheckAuth::class])->parameters(['avaliacao-agendamentos' => 'id']);

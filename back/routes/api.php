<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('users', App\Http\Controllers\UserController::class)->middleware(['check.auth'])->parameters(['users' => 'id']);

Route::apiResource('servicos', App\Http\Controllers\ServicoController::class)->middleware(['check.auth'])->parameters(['servicos' => 'id']);

Route::apiResource('pessoa-fisicas', App\Http\Controllers\PessoaFisicaController::class)->middleware(['check.auth'])->parameters(['pessoa-fisicas' => 'id']);

Route::apiResource('pessoa-juridicas', App\Http\Controllers\PessoaJuridicaController::class)->middleware(['check.auth'])->parameters(['pessoa-juridicas' => 'id']);

Route::apiResource('pessoa-juridicas', App\Http\Controllers\PessoaJuridicaController::class)->middleware(['check.auth'])->parameters(['pessoa-juridicas' => 'id']);

Route::apiResource('status-agendamentos', App\Http\Controllers\StatusAgendamentoController::class)->middleware(['check.auth'])->parameters(['status-agendamentos' => 'id']);

Route::apiResource('agendamentos', App\Http\Controllers\AgendamentoController::class)->middleware(['check.auth'])->parameters(['agendamentos' => 'id']);

Route::apiResource('avaliacao-agendamentos', App\Http\Controllers\AvaliacaoAgendamentoController::class)->middleware(['check.auth'])->parameters(['avaliacao-agendamentos' => 'id']);

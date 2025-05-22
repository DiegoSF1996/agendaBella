<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('users/logout', [App\Http\Controllers\UserController::class,'logout'])->middleware(['auth:sanctum']);
Route::post('users/login', [App\Http\Controllers\UserController::class,'login']);
Route::apiResource('users', App\Http\Controllers\UserController::class)->middleware(['auth:sanctum'])->parameters(['users' => 'id']);

Route::apiResource('servicos', App\Http\Controllers\ServicoController::class)->middleware(['auth:sanctum'])->parameters(['servicos' => 'id']);

Route::apiResource('pessoa-fisicas', App\Http\Controllers\PessoaFisicaController::class)->middleware(['auth:sanctum'])->parameters(['pessoa-fisicas' => 'id']);

Route::apiResource('pessoa-juridicas', App\Http\Controllers\PessoaJuridicaController::class)->middleware(['auth:sanctum'])->parameters(['pessoa-juridicas' => 'id']);

Route::apiResource('pessoa-juridicas', App\Http\Controllers\PessoaJuridicaController::class)->middleware(['auth:sanctum'])->parameters(['pessoa-juridicas' => 'id']);

Route::apiResource('status-agendamentos', App\Http\Controllers\StatusAgendamentoController::class)->middleware(['auth:sanctum'])->parameters(['status-agendamentos' => 'id']);

Route::get('agendamentos/obter-vagas-disponiveis', [App\Http\Controllers\AgendamentoController::class, 'obterVagasDisponiveis'])->middleware(['auth:sanctum']);
Route::put('agendamentos/{agendamento_id}/agendar-pessoa-fisica', [App\Http\Controllers\AgendamentoController::class, 'agendarPessoaFisica'])->middleware(['auth:sanctum']);
Route::post('agendamentos/desativar-agendamento', [App\Http\Controllers\AgendamentoController::class, 'desativarAgendamento'])->middleware(['auth:sanctum']);
Route::post('agendamentos/gerar-agenda-servico-mensal', [App\Http\Controllers\AgendamentoController::class, 'gerarAgendaServicoMensal'])->middleware(['auth:sanctum']);

Route::apiResource('agendamentos', App\Http\Controllers\AgendamentoController::class)->middleware(['auth:sanctum'])->parameters(['agendamentos' => 'id']);

Route::apiResource('avaliacao-agendamentos', App\Http\Controllers\AvaliacaoAgendamentoController::class)->middleware(['auth:sanctum'])->parameters(['avaliacao-agendamentos' => 'id']);

Route::apiResource('pessoa-juridica-servicos', App\Http\Controllers\PessoaJuridicaServicoController::class)->middleware(['auth:sanctum'])->parameters(['pessoa-juridica-servicos' => 'id']);


Route::apiResource('status-agendamentos', App\Http\Controllers\StatusAgendamentoController::class)->middleware(['auth:sanctum'])->parameters(['status-agendamentos' => 'id']);


Route::apiResource('servico-horarios', App\Http\Controllers\ServicoHorarioController::class)->middleware(['auth:sanctum'])->parameters(['servico-horarios' => 'id']);

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

Route::get('agendamentos/obter-vagas-disponiveis', [App\Http\Controllers\AgendamentoController::class, 'obterVagasDisponiveis'])->middleware(['check.auth']);
Route::put('agendamentos/{agendamento_id}/agendar-pessoa-fisica', [App\Http\Controllers\AgendamentoController::class, 'agendarPessoaFisica'])->middleware(['check.auth']);
Route::post('agendamentos/desativar-agendamento', [App\Http\Controllers\AgendamentoController::class, 'desativarAgendamento'])->middleware(['check.auth']);
Route::post('agendamentos/gerar-agenda-servico-mensal', [App\Http\Controllers\AgendamentoController::class, 'gerarAgendaServicoMensal'])->middleware(['check.auth']);

Route::apiResource('agendamentos', App\Http\Controllers\AgendamentoController::class)->middleware(['check.auth'])->parameters(['agendamentos' => 'id']);

Route::apiResource('avaliacao-agendamentos', App\Http\Controllers\AvaliacaoAgendamentoController::class)->middleware(['check.auth'])->parameters(['avaliacao-agendamentos' => 'id']);

Route::apiResource('pessoa-juridica-servicos', App\Http\Controllers\PessoaJuridicaServicoController::class)->middleware(['check.auth'])->parameters(['pessoa-juridica-servicos' => 'id']);


Route::apiResource('status-agendamentos', App\Http\Controllers\StatusAgendamentoController::class)->middleware(['check.auth'])->parameters(['status-agendamentos' => 'id']);


Route::apiResource('servico-horarios', App\Http\Controllers\ServicoHorarioController::class)->middleware(['check.auth'])->parameters(['servico-horarios' => 'id']);

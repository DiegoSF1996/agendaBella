<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agendamento>
 */
class AgendamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'pessoa_fisica_id' => '',
			'pessoa_juridica_id' => '',
			'servico_id' => '',
			'data_hora_agendamento' => '',
			'data_hora_conclusao' => '',
			'status_agendamento_id' => '',
			'observacao' => '',
        ];
    }
}

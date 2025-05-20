<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AvaliacaoAgendamento>
 */
class AvaliacaoAgendamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'agendamento_id' => '',
			'nota_avaliacao_da_pessoa_fisica' => '',
			'nota_avaliacao_da_pessoa_juridica' => '',
			'observacao_da_pessoa_fisica' => '',
			'observacao_da_pessoa_juridica' => '',
        ];
    }
}

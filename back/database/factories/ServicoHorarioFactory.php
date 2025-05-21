<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServicoHorario>
 */
class ServicoHorarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'pessoa_juridica_id' => '',
			'dia_semana' => '',
			'horario_inicio' => '',
			'horario_fim' => '',
			'tempo_medio' => '',
        ];
    }
}

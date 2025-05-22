<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\StatusAgendamento as StatusAgendamentoModel;

class StatusAgendamento extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $array_status =  [
            [
                'descricao' => 'Disponível',
                'codigo' => '1',
            ],
            [
                'descricao' => 'Agendado',
                'codigo' => '2',
            ],
            [
                'descricao' => 'Cancelado',
                'codigo' => '3',
            ],
            [
                'descricao' => 'Concluído',
                'codigo' => '4',
            ],
            [
                'descricao' => 'Em Andamento',
                'codigo' => '5',
            ]
        ];
        array_map(function ($status) {
            StatusAgendamentoModel::create($status);
        }, $array_status);
    }
}

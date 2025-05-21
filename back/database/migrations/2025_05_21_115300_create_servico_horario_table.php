<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servico_horario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_juridica_servico_id')->constrained('pessoa_juridica_servico')->onDelete('cascade');
            $table->integer('dia_semana')->comment('0 - Domingo, 1 - Segunda, 2 - Terça, 3 - Quarta, 4 - Quinta, 5 - Sexta, 6 - Sábado');
            $table->time('hora_inicio')->comment('Hora de início do serviço');
            $table->time('hora_fim')->comment('Hora de término do serviço');
            $table->integer('tempo_medio')->comment('Tempo médio de atendimento em minutos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico_horario');
    }
};

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
        Schema::create('agendamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_fisica_id')->constrained('pessoa_fisica')->onDelete('cascade');
            $table->foreignId('pessoa_juridica_id')->constrained('pessoa_juridica')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servico')->onDelete('cascade');
            $table->dateTime('data_hora_agendamento');
            $table->dateTime('data_hora_conclusao');
            $table->foreignId('status_agendamento_id')->constrained('status_agendamento')->onDelete('cascade');
            $table->string('observacao')->max(255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamento');
    }
};

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
        Schema::create('avaliacao_agedamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agendamento_id')->constrained('agendamento');
            $table->integer('nota_avaliacao_da_pessoa_fisica');
            $table->integer('nota_avaliacao_da_pessoa_juridica');
            $table->string('observacao_da_pessoa_fisica')->max(255);
            $table->string('observacao_da_pessoa_juridica')->max(255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacao_agedamento');
    }
};

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
        Schema::table('agendamento', function (Blueprint $table) {
            //
            $table->foreignId('servico_horario_id')->constrained('servico_horario');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamento', function (Blueprint $table) {
            //
            $table->dropForeign(['servico_horario_id']);
            $table->dropColumn('servico_horario_id');
        });
    }
};

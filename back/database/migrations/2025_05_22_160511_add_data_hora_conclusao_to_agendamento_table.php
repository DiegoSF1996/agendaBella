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
            $table->timestamp('data_hora_conclusao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamento', function (Blueprint $table) {
            //
            $table->dropColumn('data_hora_conclusao');
        });
    }
};

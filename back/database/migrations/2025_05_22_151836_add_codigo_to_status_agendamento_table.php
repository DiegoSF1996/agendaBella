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
        Schema::table('status_agendamento', function (Blueprint $table) {
            //
            $table->string('codigo', 2)->after('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_agendamento', function (Blueprint $table) {
            //
            $table->dropColumn('codigo');
        });
    }
};

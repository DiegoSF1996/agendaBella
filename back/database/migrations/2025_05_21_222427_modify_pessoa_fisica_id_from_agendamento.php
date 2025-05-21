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
            $table->dropForeign(['pessoa_fisica_id']);
            $table->dropColumn('pessoa_fisica_id');
            $table->foreignId('pessoa_fisica_id')->nullable()->constrained('pessoa_fisica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamento', function (Blueprint $table) {
            //
            $table->dropForeign(['pessoa_fisica_id']);
            $table->dropColumn('pessoa_fisica_id');
            $table->foreignId('pessoa_fisica_id')->constrained('pessoa_fisica');
        });
    }
};

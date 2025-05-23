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
        Schema::create('pessoa_juridica_servico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pessoa_juridica_id')->constrained('pessoa_juridica');
            $table->foreignId('servico_id')->constrained('servico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoa_juridica_servico');
    }
};

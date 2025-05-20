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
        Schema::create('pessoa_juridica', function (Blueprint $table) {
            $table->id();
            $table->string('nome_fantasia');
            $table->foreingId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('cnpj')->max(14)->unique();
            $table->string('telefone');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoa_juridica');
    }
};

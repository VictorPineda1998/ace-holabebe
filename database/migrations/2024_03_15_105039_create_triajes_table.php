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
        Schema::create('triajes', function (Blueprint $table) {
            $table->id();
            $table->json('observaciones')->nullable(); // Usando json para almacenar datos estructurados
            $table->json('interrogatorio')->nullable(); // Usando json para almacenar datos estructurados
            $table->json('signos_vitales')->nullable(); // Usando json para almacenar datos estructurados
            $table->json('bienestar_fetal')->nullable(); // Usando json para almacenar datos estructurados
            $table->json('toma_signos_vitales'); // Usando json para almacenar datos estructurados
            $table->string('resultado')->nullable();
            $table->unsignedBigInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('triajes');
    }
};

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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_consulta');
            $table->text('detalles_consulta')->nullable();
            $table->enum('estado', ['próxima', 'confirmada', 'cancelada', 'finalizada'])->default('próxima')->length(20);
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')-> on ('pacientes')->onDelete('cascade');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultass');
    }
};

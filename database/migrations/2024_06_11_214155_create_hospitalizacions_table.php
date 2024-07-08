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
        Schema::create('hospitalizacions', function (Blueprint $table) {
            $table->id();
            $table->string('habitacion');
            $table->string('servicio');
            $table->string('procedimiento');
            $table->date('fecha_alta')->nullable();                       
            $table->string('medico_tratante');                 
            $table->string('dietas');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalizacions');
    }
};

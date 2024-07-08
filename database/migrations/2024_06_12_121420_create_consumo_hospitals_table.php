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
        Schema::create('consumo_hospitals', function (Blueprint $table) {
            $table->id();
            $table->json('materiales')->nullable();
            $table->json('medicamentos')->nullable();
            $table->json('guardias_henfermeria')->nullable();  
            $table->json('hospitalizacion')->nullable();  
            $table->json('honorarios_medicos')->nullable();             
            $table->unsignedBigInteger('hospitalizacion_id');
            $table->foreign('hospitalizacion_id')->references('id')->on('hospitalizacions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumo_hospitals');
    }
};

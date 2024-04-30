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
        Schema::create('colposcopias', function (Blueprint $table) {
            $table->id();
            $table->json('ahf')->nullable();
            $table->json('app')->nullable();
            $table->json('ago')->nullable();
            $table->json('ago2')->nullable();
            // $table->string('ruta');
            $table->unsignedBigInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colposcopias');
    }
};

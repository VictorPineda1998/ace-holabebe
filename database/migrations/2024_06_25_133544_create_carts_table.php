<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('carts', function (Blueprint $table) {
        $table->id();
        $table->json('items'); // Almacena los elementos del carrito en formato JSON
        $table->timestamps();
        $table->unsignedBigInteger('hospitalizacion_id'); 
        $table->foreign('hospitalizacion_id')->references('id')->on('hospitalizacions')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

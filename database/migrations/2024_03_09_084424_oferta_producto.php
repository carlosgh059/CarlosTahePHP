<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    //la relacion es muchas ofertas pueden pertenecer a muchos productos con lo cual
    //esto es una talba intermedia entre ofertas y productos
    public function up(): void
    {
        Schema::create('oferta_producto', function (Blueprint $table) {
            $table->id('UUIDofertaProducto');

            $table->unsignedBigInteger('oferta_id')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('opcion_id')->nullable();

            $table->foreign('oferta_id')->references('UUIDoferta')->on('ofertas')->onDelete('cascade');
            $table->foreign('producto_id')->references('UUIDproducto')->on('productos')->onDelete('cascade');
            $table->foreign('opcion_id')->references('UUIDopciones')->on('opciones')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_producto');
    }
};

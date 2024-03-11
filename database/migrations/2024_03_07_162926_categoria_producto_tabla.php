<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        //
        Schema::create('categoria_producto', function (Blueprint $table) {
            $table->id('UUIDcategoria_producto');

            $table->unsignedBigInteger('UUIDcategoria')->nullable();
            $table->unsignedBigInteger('UUIDproducto')->nullable();
            $table->unsignedBigInteger('UUIDopciones')->nullable();

            $table->foreign('UUIDcategoria')->references('UUIDcategoria')->on('categorias')->onDelete('cascade');
            $table->foreign('UUIDproducto')->references('UUIDproducto')->on('productos')->onDelete('cascade');
            $table->foreign('UUIDopciones')->references('UUIDopciones')->on('opciones')->onDelete('cascade');

            $table->timestamps();
        });    }


    public function down(): void
    {
        //
        Schema::dropIfExists('categoria_producto');

    }
};

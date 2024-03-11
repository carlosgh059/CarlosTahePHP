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
        Schema::create('informacion_pedidos', function (Blueprint $table) {
            $table->id('UUIDinformacionpedido');
            $table->enum('estado', ['pendiente', 'en_proceso', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->string('descripcion')->nullable();
            //la relacion 1 a 1 con pedido
            $table->unsignedBigInteger('pedido_id');
            $table->foreign('pedido_id')->references('UUIDpedido')->on('pedidos')->onDelete('cascade');

            //la relacion 1 a muchos con usuario
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_pedidos');
    }
};

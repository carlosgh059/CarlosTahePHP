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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('UUIDpedido');
            $table->decimal('precio_total', 8, 2); // Precio total del pedido
            $table->text('descripcion')->nullable(); // Descripción opcional del pedido
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado'])->default('pendiente'); // Estado del pedido
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};

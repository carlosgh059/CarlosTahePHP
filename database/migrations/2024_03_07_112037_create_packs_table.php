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
        Schema::create('packs', function (Blueprint $table) {
            $table->id('UUIDpack');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2);
            $table->string('imagen')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');

            //relacion con cesta
            $table->unsignedBigInteger('cesta_id')->nullable();
            $table->foreign('cesta_id')->references('UUIDcesta')->on('cestas')->onDelete('cascade')->onUpdate('cascade');
            //relacion con pedidos
            $table->unsignedBigInteger('pedido_id')->nullable();
            $table->foreign('pedido_id')->references('UUIDpedido')->on('pedidos')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packs');
    }
};

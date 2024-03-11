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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('UUIDproducto');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2);
            $table->string('imagenprincipal')->nullable();
            $table->json('imagenes')->nullable();
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
          
            //relacion con pedidos
            $table->unsignedBigInteger('pedido_id')->nullable();
            $table->foreign('pedido_id')->references('UUIDpedido')->on('pedidos')->onDelete('cascade')->onUpdate('cascade');

            // Clave foránea para la relación con los packs
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->foreign('pack_id')->references('UUIDpack')->on('packs')->onDelete('cascade')->onUpdate('cascade');

            //relacion con cesta
            $table->unsignedBigInteger('cesta_id')->nullable();
            $table->foreign('cesta_id')->references('UUIDcesta')->on('cestas')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

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
        Schema::create('opciones', function (Blueprint $table) {
            $table->id('UUIDopciones');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->decimal('precio', 8, 2);
            $table->enum('asociadoProducto', ['Si', 'No'])->default('No'); // Nuevo campo enum para indicar si está asociado a un producto
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
           
            //relacion con productos
            $table->unsignedBigInteger('productos_id')->nullable();
            $table->foreign('productos_id')->references('UUIDproducto')->on('productos')->onDelete('cascade')->onUpdate('cascade');
    
            //relacion con pedidos
            $table->unsignedBigInteger('pedido_id')->nullable();
            $table->foreign('pedido_id')->references('UUIDpedido')->on('pedidos')->onDelete('cascade')->onUpdate('cascade');

            //relacion con cesta
            $table->unsignedBigInteger('cesta_id')->nullable();
            $table->foreign('cesta_id')->references('UUIDcesta')->on('cestas')->onDelete('cascade')->onUpdate('cascade');

            // Clave foránea para la relación con los packs
            $table->unsignedBigInteger('pack_id')->nullable();
            $table->foreign('pack_id')->references('UUIDpack')->on('packs')->onDelete('cascade')->onUpdate('cascade');
                    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones');
    }
};

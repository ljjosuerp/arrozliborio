<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Puntos de venta físicos (supermercados) para el mapa "Dónde comprar".
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('puntos_venta', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->string('region')->nullable();
            $t->string('direccion')->nullable();
            $t->decimal('lat', 10, 6)->nullable();
            $t->decimal('lng', 10, 6)->nullable();
            $t->string('precision')->default('aproximada'); // exacta | aproximada
            $t->json('productos')->nullable();              // ["Arroz","Frijoles","Aceite"]
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('puntos_venta');
    }
};

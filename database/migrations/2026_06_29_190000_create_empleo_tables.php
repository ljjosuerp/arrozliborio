<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Portal de empleo: aspirantes (perfil + CV) y aplicaciones a vacantes (blueprint §4).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aspirantes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $t->string('nombre');
            $t->string('telefono')->nullable();
            $t->string('cv_path')->nullable();
            $t->string('cv_nombre')->nullable();
            $t->timestamps();
        });

        Schema::create('aplicaciones', function (Blueprint $t) {
            $t->id();
            $t->foreignId('aspirante_id')->constrained('aspirantes')->cascadeOnDelete();
            $t->foreignId('puesto_vacante_id')->constrained('puestos_vacantes')->cascadeOnDelete();
            $t->text('mensaje')->nullable();
            $t->string('estado')->default('recibida'); // recibida | en revisión | descartada | contratado
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aplicaciones');
        Schema::dropIfExists('aspirantes');
    }
};

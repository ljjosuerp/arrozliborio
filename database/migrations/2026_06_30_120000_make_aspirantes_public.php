<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Postulaciones públicas: el aspirante ya no requiere cuenta de usuario.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirantes', function (Blueprint $t) {
            $t->string('email')->nullable()->after('nombre');
            $t->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('aspirantes', function (Blueprint $t) {
            $t->dropColumn('email');
        });
    }
};

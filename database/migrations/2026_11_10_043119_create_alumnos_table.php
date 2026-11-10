<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla alumnos.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_control', 10)->unique();
            $table->string('nombre', 120);
            $table->string('correo')->unique();
            $table->string('carrera', 80);
            $table->unsignedTinyInteger('semestre');
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla alumnos.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};

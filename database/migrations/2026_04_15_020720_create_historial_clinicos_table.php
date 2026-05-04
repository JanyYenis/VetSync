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
        Schema::create('historial_clinicos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigIncrements('numero_consecutivo'); // 👈 clave
            $table->string('codigo')->unique()->nullable();
            $table->uuid('cod_mascota');
            $table->uuid('cod_cliente');
            $table->uuid('cod_usuario');
            $table->integer('edad');
            $table->string('peso');
            $table->timestamp('rabia')->nullable();
            $table->timestamp('parvovirus')->nullable();
            $table->timestamp('moquillo')->nullable();
            $table->timestamp('desparasitacion_interna')->nullable();
            $table->timestamp('desparasitacion_externa')->nullable();
            $table->text('alergias')->nullable();
            $table->text('enfermedades_cronicas')->nullable();
            $table->text('observacion_general')->nullable();
            $table->text('firma')->nullable();
            $table->string('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_clinicos');
    }
};

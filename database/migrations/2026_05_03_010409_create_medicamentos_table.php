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
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cod_prescripcion');
            $table->string('nombre');
            $table->integer('presentacion')->default(1);
            $table->string('dosis');
            $table->integer('frecuencia')->default(1);
            $table->integer('duracion');
            $table->integer('tiempo')->default(1);
            $table->integer('estado')->default(1);
            $table->string('comentario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};

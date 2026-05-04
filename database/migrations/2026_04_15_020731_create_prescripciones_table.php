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
        Schema::create('prescripciones', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cod_historial');
            $table->uuid('cod_usuario');
            $table->text('indicaciones')->nullable();
            $table->timestamp('fecha');
            $table->integer('validez')->default(1);
            $table->integer('confirmacion')->nullable();
            $table->integer('estado')->default(1);
            $table->text('firma')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescripciones');
    }
};

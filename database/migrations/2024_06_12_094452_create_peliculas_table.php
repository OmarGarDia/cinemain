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
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->unsignedSmallInteger('año')->nullable();
            $table->text('sinopsis')->nullable();
            $table->unsignedSmallInteger('duracion')->nullable();
            $table->string('idioma')->nullable();
            $table->string('pais')->nullable();
            $table->string('genero')->nullable();
            $table->float('calificacion')->nullable();
            $table->string('imagen')->nullable();
            $table->string('trailer')->nullable();
            $table->date('fecha_estreno')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};

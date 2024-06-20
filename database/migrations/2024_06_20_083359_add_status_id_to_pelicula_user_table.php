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
        Schema::table('pelicula_user', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->nullable();

            $table->foreign('status_id')->references('id')->on('status_movie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pelicula_user', function (Blueprint $table) {
            $table->dropForeign(['status_id']);

            $table->dropColumn('status_id');
        });
    }
};

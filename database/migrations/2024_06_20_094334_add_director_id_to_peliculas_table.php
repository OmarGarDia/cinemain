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
        Schema::table('peliculas', function (Blueprint $table) {
            $table->unsignedBigInteger('director_id')->nullable();
            $table->foreign('director_id')->references('id')->on('directors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peliculas', function (Blueprint $table) {
            $table->dropForeign(['director_id']);
            $table->dropColumn('director_id');
        });
    }
};

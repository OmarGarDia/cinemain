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
        Schema::table('episode', function (Blueprint $table) {
            $table->foreignId('serie_id')->constrained('series')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('episode', function (Blueprint $table) {
            $table->dropForeign(['serie_id']);
            $table->dropColumn('serie_id');
        });
    }
};

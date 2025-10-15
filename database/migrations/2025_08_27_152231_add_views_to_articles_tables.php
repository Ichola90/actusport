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
        Schema::table('mercatos', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0);
        });

        Schema::table('omnisports', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0);
        });

        Schema::table('wags', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0);
        });

        Schema::table('celebrites', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0);
        });

        Schema::table('actusports', function (Blueprint $table) {
            $table->unsignedBigInteger('views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mercatos', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('omnisports', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('wags', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('celebrites', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('actusports', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};

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
        Schema::table('cadets', function (Blueprint $table) {
            // make user_id nullable so it won't require value
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            // revert back to required (NOT NULL)
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            // 1. DROP FOREIGN KEY FIRST
            if (Schema::hasColumn('deployments', 'user_id')) {
                $table->dropForeign(['user_id']);
            }

            // 2. THEN DROP COLUMN
            if (Schema::hasColumn('deployments', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
        });
    }
};
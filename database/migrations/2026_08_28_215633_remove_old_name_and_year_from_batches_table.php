<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('batches', 'year')) {
                $table->dropColumn('year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (!Schema::hasColumn('batches', 'name')) {
                $table->string('name')->nullable();
            }

            if (!Schema::hasColumn('batches', 'year')) {
                $table->string('year')->nullable();
            }
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            // ONLY ADD percentage
            if (!Schema::hasColumn('deployments', 'percentage')) {
                $table->integer('percentage')->default(0);
            }

        });
    }

    public function down(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            if (Schema::hasColumn('deployments', 'percentage')) {
                $table->dropColumn('percentage');
            }

        });
    }
};
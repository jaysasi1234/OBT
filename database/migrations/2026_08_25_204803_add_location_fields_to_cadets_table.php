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

            if (!Schema::hasColumn('cadets', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('cadets', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable();
            }

            if (!Schema::hasColumn('cadets', 'location_updated_at')) {
                $table->timestamp('location_updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {

            if (Schema::hasColumn('cadets', 'latitude')) {
                $table->dropColumn('latitude');
            }

            if (Schema::hasColumn('cadets', 'longitude')) {
                $table->dropColumn('longitude');
            }

            if (Schema::hasColumn('cadets', 'location_updated_at')) {
                $table->dropColumn('location_updated_at');
            }
        });
    }
};
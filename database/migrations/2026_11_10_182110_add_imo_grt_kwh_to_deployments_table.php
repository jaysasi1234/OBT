<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            $table->string('imo_number', 20)->nullable();
            $table->decimal('grt', 12, 2)->nullable();
            $table->decimal('kwh', 14, 2)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            $table->dropColumn([
                'imo_number',
                'grt',
                'kwh',
            ]);

        });
    }
};
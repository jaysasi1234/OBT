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
        Schema::table('deployments', function (Blueprint $table) {

            $table->string('embarkation_place')->nullable()->after('company_name');

            $table->string('disembarkation_place')->nullable()->after('date_deployed');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deployments', function (Blueprint $table) {

            $table->dropColumn([
                'embarkation_place',
                'disembarkation_place'
            ]);

        });
    }
};
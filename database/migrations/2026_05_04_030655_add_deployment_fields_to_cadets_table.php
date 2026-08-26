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

            // COMPANY
            if (!Schema::hasColumn('cadets', 'company')) {
                $table->string('company')->nullable()->after('batch_id');
            }

            // DATE DEPLOYED
            if (!Schema::hasColumn('cadets', 'date_deployed')) {
                $table->date('date_deployed')->nullable()->after('company');
            }

            // DATE DISEMBARKED
            if (!Schema::hasColumn('cadets', 'date_disembarked')) {
                $table->date('date_disembarked')->nullable()->after('date_deployed');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {

            if (Schema::hasColumn('cadets', 'company')) {
                $table->dropColumn('company');
            }

            if (Schema::hasColumn('cadets', 'date_deployed')) {
                $table->dropColumn('date_deployed');
            }

            if (Schema::hasColumn('cadets', 'date_disembarked')) {
                $table->dropColumn('date_disembarked');
            }

        });
    }
};
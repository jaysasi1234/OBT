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

            $table->string('remarks_month')->nullable();
            $table->string('remarks_year')->nullable();
            $table->string('remarks_updated_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {

            $table->dropColumn('remarks_month');
            $table->dropColumn('remarks_year');
            $table->dropColumn('remarks_updated_by');

        });
    }
};
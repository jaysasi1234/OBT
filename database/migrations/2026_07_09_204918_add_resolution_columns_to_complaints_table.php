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
        Schema::table('complaints', function (Blueprint $table) {

            // Admin remarks
            $table->text('remarks')->nullable()->after('action_taken');

            // Supporting file uploaded during resolution
            $table->string('support_file')->nullable()->after('remarks');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {

            $table->dropColumn([
                'remarks',
                'support_file',
            ]);

        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {

            // Make courses nullable so insert will NOT fail
            $table->text('courses')->nullable()->change();

        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {

            // revert back (optional)
            $table->text('courses')->nullable(false)->change();

        });
    }
};
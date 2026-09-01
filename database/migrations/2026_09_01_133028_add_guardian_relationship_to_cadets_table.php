<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->string('guardian_relationship')->nullable()->after('parent_guardian_address');
        });
    }

    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->dropColumn('guardian_relationship');
        });
    }
};
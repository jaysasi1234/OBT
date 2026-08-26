<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadets', function (Blueprint $table) {

            // ONLY ADD if they don't exist yet
            if (!Schema::hasColumn('cadets', 'parent_guardian_name')) {
                $table->string('parent_guardian_name')->nullable();
            }

            if (!Schema::hasColumn('cadets', 'parent_guardian_contact')) {
                $table->string('parent_guardian_contact')->nullable();
            }

            if (!Schema::hasColumn('cadets', 'parent_guardian_email')) {
                $table->string('parent_guardian_email')->nullable();
            }

            if (!Schema::hasColumn('cadets', 'parent_guardian_address')) {
                $table->text('parent_guardian_address')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {

            if (Schema::hasColumn('cadets', 'parent_guardian_name')) {
                $table->dropColumn('parent_guardian_name');
            }

            if (Schema::hasColumn('cadets', 'parent_guardian_contact')) {
                $table->dropColumn('parent_guardian_contact');
            }

            if (Schema::hasColumn('cadets', 'parent_guardian_email')) {
                $table->dropColumn('parent_guardian_email');
            }

            if (Schema::hasColumn('cadets', 'parent_guardian_address')) {
                $table->dropColumn('parent_guardian_address');
            }

        });
    }
};
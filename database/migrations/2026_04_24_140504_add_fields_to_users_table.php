<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('email');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->after('password');
            }

            if (!Schema::hasColumn('users', 'course')) {
                $table->string('course')->nullable()->after('role');
            }

            if (!Schema::hasColumn('users', 'contact')) {
                $table->string('contact')->nullable()->after('course');
            }

            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('contact');
            }

            if (!Schema::hasColumn('users', 'trb_no')) {
                $table->string('trb_no')->nullable()->after('status');
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }

            if (Schema::hasColumn('users', 'course')) {
                $table->dropColumn('course');
            }

            if (Schema::hasColumn('users', 'contact')) {
                $table->dropColumn('contact');
            }

            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('users', 'trb_no')) {
                $table->dropColumn('trb_no');
            }

            // ⚠️ DO NOT DROP role if it already existed before
        });
    }
};
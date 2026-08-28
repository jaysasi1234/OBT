<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->string('parent_guardian_name')->nullable()->change();
            $table->string('parent_guardian_contact')->nullable()->change();
            $table->string('parent_guardian_email')->nullable()->change();
            $table->text('parent_guardian_address')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('cadets', function (Blueprint $table) {
            $table->string('parent_guardian_name')->nullable(false)->change();
            $table->string('parent_guardian_contact')->nullable(false)->change();
            $table->string('parent_guardian_email')->nullable(false)->change();
            $table->text('parent_guardian_address')->nullable(false)->change();
        });
    }
};
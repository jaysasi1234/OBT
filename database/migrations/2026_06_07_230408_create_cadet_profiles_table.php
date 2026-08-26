<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadet_profiles', function (Blueprint $table) {
            $table->id();

            // Link to users table
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Profile fields
            $table->string('batch')->nullable();
            $table->date('dob')->nullable();
            $table->string('birth_place')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_no')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadet_profiles');
    }
};
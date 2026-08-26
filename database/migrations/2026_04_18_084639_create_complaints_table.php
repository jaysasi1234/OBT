<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            // USER (CADET WHO CREATED)
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // OPTIONAL: LINK TO CADET PROFILE (IF YOU USE cadets TABLE)
            $table->foreignId('cadet_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // ADMIN WHO HANDLED IT
            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // CONTENT
            $table->string('subject');
            $table->text('description');
            $table->text('action_taken')->nullable();

            // STATUS (UPDATED)
            $table->enum('status', [
                'Open',
                'Pending',
                'Resolved',
                'Rejected'
            ])->default('Open');

            // DATES
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadet_onboard_requirements', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cadet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('onboard_requirement_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('status')->default('Pending');

            $table->timestamp('submitted_at')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(
                ['cadet_id', 'onboard_requirement_id'],
                'cadet_requirement_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadet_onboard_requirements');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadet_b_s_requirements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cadet_id')
                ->constrained('cadets')
                ->cascadeOnDelete();

            $table->foreignId('b_s_requirement_id')
                ->constrained('bs_requirements')
                ->cascadeOnDelete();

            $table->string('attachment')->nullable();

            $table->enum('status', [
                'Pending',
                'Submitted',
                'Approved',
                'Rejected'
            ])->default('Submitted');

            $table->text('remarks')->nullable();

            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->unique([
                'cadet_id',
                'b_s_requirement_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadet_b_s_requirements');
    }
};
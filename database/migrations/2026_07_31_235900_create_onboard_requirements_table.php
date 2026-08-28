<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onboard_requirements', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('frequency', [
                'One Time',
                'Weekly',
                'Monthly',
                'End of Training'
            ])->default('One Time');

            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);

            $table->string('sort_order')->nullable();

            $table->integer('due_after_days')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboard_requirements');
    }
};
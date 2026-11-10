<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadet_insurances', function (Blueprint $table) {
            $table->id();

            // One insurance record per cadet
            $table->foreignId('cadet_id')
                ->unique()
                ->constrained('cadets')
                ->cascadeOnDelete();

            // Admin who uploaded the document
            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadet_insurances');
    }
};
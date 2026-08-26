<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_settings', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->text('description')->nullable();
            $table->string('status')->default('Active');
            $table->boolean('include_logo')->default(true);
            $table->boolean('include_date')->default(true);
            $table->string('report_format')->default('PDF');
            $table->string('default_title')->default('Cadet Information Report');
            $table->boolean('export_pdf')->default(true);
            $table->boolean('export_excel')->default(true);
            $table->boolean('allow_print')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_settings');
    }
};
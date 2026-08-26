<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cadets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained()->onDelete('set null');
            $table->string('trb_control_number')->unique();
            $table->string('full_name');
            $table->enum('course', ['BSMT', 'BSMarE']);
            $table->date('date_of_enrollment');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->text('address');
            $table->string('contact_number');
            $table->string('parent_guardian_name');
            $table->string('parent_guardian_contact');
            $table->enum('deployment_status', ['Not Deployed', 'Ongoing', 'Completed'])->default('Not Deployed');
            $table->decimal('deployment_percentage', 5, 2)->default(0);
            $table->enum('verification_status', ['Verified', 'Pending', 'Deficiency'])->default('Pending');
            $table->string('bs_status')->nullable();
            $table->boolean('is_off_semester')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cadets');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipped_on_orders', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cadet_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('deliberation_date')->nullable();

            $table->enum('deliberation_status',[
                'Pending',
                'Approved',
                'Disapproved'
            ])->default('Pending');

            $table->date('obt_endorsement_date')->nullable();

            $table->string('so_number')->nullable();

            $table->date('so_date_issued')->nullable();

            $table->enum('status',[
                'Pending',
                'For Deliberation',
                'For Endorsement',
                'Shipped',
                'Completed'
            ])->default('Pending');

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipped_on_orders');
    }
};

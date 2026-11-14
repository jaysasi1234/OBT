<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->string('marina_accreditation_number')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->dropColumn([
                'marina_accreditation_number',
                'valid_from',
                'valid_until',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deployments', function (Blueprint $table) {
            $table->date('date_deployed')->nullable()->change();
            $table->date('date_disembarked')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('deployments', function (Blueprint $table) {
            $table->date('date_deployed')->nullable(false)->change();
            $table->date('date_disembarked')->nullable(false)->change();
        });
    }
};
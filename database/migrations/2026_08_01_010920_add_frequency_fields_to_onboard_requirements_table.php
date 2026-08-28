<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onboard_requirements', function (Blueprint $table) {

            if (!Schema::hasColumn('onboard_requirements', 'frequency')) {
                $table->enum('frequency', [
                    'One Time',
                    'Weekly',
                    'Monthly',
                    'End of Training'
                ])->default('One Time')->after('description');
            }

            if (!Schema::hasColumn('onboard_requirements', 'due_after_days')) {
                $table->unsignedInteger('due_after_days')
                    ->nullable()
                    ->after('frequency');
            }

        });
    }

    public function down(): void
    {
        Schema::table('onboard_requirements', function (Blueprint $table) {

            if (Schema::hasColumn('onboard_requirements', 'due_after_days')) {
                $table->dropColumn('due_after_days');
            }

            if (Schema::hasColumn('onboard_requirements', 'frequency')) {
                $table->dropColumn('frequency');
            }

        });
    }
};
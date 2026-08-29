<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('cadet_onboard_requirements', 'attachment')) {
            Schema::table('cadet_onboard_requirements', function (Blueprint $table) {
                $table->string('attachment')->nullable()->after('onboard_requirement_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('cadet_onboard_requirements', 'attachment')) {
            Schema::table('cadet_onboard_requirements', function (Blueprint $table) {
                $table->dropColumn('attachment');
            });
        }
    }
};
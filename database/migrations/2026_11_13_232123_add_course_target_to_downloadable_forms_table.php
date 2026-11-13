
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('downloadable_forms', function (Blueprint $table) {
            $table->string('course_target', 20)
                ->default('all')
                ->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('downloadable_forms', function (Blueprint $table) {
            $table->dropColumn('course_target');
        });
    }
};

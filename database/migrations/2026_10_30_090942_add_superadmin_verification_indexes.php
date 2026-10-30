
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadet_documents', function (Blueprint $table) {
            $table->index(
                ['cadet_id', 'status'],
                'cadet_documents_cadet_status_index'
            );
        });

        Schema::table('cadet_b_s_requirements', function (Blueprint $table) {
            $table->index(
                ['cadet_id', 'status'],
                'cadet_bs_cadet_status_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('cadet_documents', function (Blueprint $table) {
            $table->dropIndex('cadet_documents_cadet_status_index');
        });

        Schema::table('cadet_b_s_requirements', function (Blueprint $table) {
            $table->dropIndex('cadet_bs_cadet_status_index');
        });
    }
};

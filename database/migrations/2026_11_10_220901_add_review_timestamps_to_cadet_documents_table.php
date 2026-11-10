
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadet_documents', function (Blueprint $table) {

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamp('rejected_at')->nullable();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('cadet_documents', function (Blueprint $table) {

            $table->dropForeign(['reviewed_by']);

            $table->dropColumn([
                'reviewed_at',
                'approved_at',
                'rejected_at',
                'reviewed_by',
            ]);

        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            // These columns already exist:
            // is_delivered
            // delivered_at
            // is_read

            $table->timestamp('read_at')
                ->nullable()
                ->after('is_read');

            $table->timestamp('edited_at')
                ->nullable()
                ->after('read_at');

            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            $table->dropColumn([
                'read_at',
                'edited_at',
            ]);

            $table->dropSoftDeletes();

        });
    }
};

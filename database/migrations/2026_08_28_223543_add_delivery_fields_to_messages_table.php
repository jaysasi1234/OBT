<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('messages', 'is_delivered')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->boolean('is_delivered')
                    ->default(false)
                    ->after('is_read');
            });
        }

        if (!Schema::hasColumn('messages', 'delivered_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->timestamp('delivered_at')
                    ->nullable()
                    ->after('is_delivered');
            });
        }
    }

    public function down(): void
    {
        $columns = [];

        if (Schema::hasColumn('messages', 'is_delivered')) {
            $columns[] = 'is_delivered';
        }

        if (Schema::hasColumn('messages', 'delivered_at')) {
            $columns[] = 'delivered_at';
        }

        if (!empty($columns)) {
            Schema::table('messages', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
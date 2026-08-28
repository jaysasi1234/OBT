<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('messages', 'chat_group_id')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->unsignedBigInteger('chat_group_id')
                    ->nullable()
                    ->after('receiver_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('messages', 'chat_group_id')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropColumn('chat_group_id');
            });
        }
    }
};
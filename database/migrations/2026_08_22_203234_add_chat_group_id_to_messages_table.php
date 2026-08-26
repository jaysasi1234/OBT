<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | GROUP ID
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('messages', 'chat_group_id')) {

            Schema::table('messages', function (Blueprint $table) {

                $table->foreignId('chat_group_id')
                    ->nullable()
                    ->after('receiver_id')
                    ->constrained('chat_groups')
                    ->cascadeOnDelete();

                $table->index('chat_group_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | RECEIVER ID MUST BE NULLABLE FOR GROUP MESSAGES
        |--------------------------------------------------------------------------
        |
        | Direct message:
        |
        | sender_id = 5
        | receiver_id = 10
        | chat_group_id = NULL
        |
        | Group message:
        |
        | sender_id = 5
        | receiver_id = NULL
        | chat_group_id = 3
        |
        */

        Schema::table('messages', function (Blueprint $table) {

            $table->foreignId('receiver_id')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('messages', 'chat_group_id')) {

            Schema::table('messages', function (Blueprint $table) {

                $table->dropForeign([
                    'chat_group_id'
                ]);

                $table->dropColumn(
                    'chat_group_id'
                );
            });
        }
    }
};
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
        | CREATE TABLE IF IT DOES NOT EXIST
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasTable('chat_group_members')) {

            Schema::create('chat_group_members', function (Blueprint $table) {

                $table->id();

                $table->foreignId('chat_group_id')
                    ->constrained('chat_groups')
                    ->cascadeOnDelete();

                $table->foreignId('user_id')
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->string('role')
                    ->default('member');

                $table->timestamp('joined_at')
                    ->nullable();

                $table->timestamps();

                $table->unique([
                    'chat_group_id',
                    'user_id'
                ]);
            });

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | ADD chat_group_id IF MISSING
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('chat_group_members', 'chat_group_id')) {

            Schema::table('chat_group_members', function (Blueprint $table) {

                $table->foreignId('chat_group_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('chat_groups')
                    ->cascadeOnDelete();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | ADD user_id IF MISSING
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('chat_group_members', 'user_id')) {

            Schema::table('chat_group_members', function (Blueprint $table) {

                $table->foreignId('user_id')
                    ->nullable()
                    ->after('chat_group_id')
                    ->constrained('users')
                    ->cascadeOnDelete();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | ADD ROLE IF MISSING
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('chat_group_members', 'role')) {

            Schema::table('chat_group_members', function (Blueprint $table) {

                $table->string('role')
                    ->default('member')
                    ->after('user_id');
            });
        }


        /*
        |--------------------------------------------------------------------------
        | ADD JOINED AT IF MISSING
        |--------------------------------------------------------------------------
        */

        if (!Schema::hasColumn('chat_group_members', 'joined_at')) {

            Schema::table('chat_group_members', function (Blueprint $table) {

                $table->timestamp('joined_at')
                    ->nullable()
                    ->after('role');
            });
        }
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Do not destroy an existing production table automatically.
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('chat_group_members')) {

            if (Schema::hasColumn('chat_group_members', 'chat_group_id')) {

                Schema::table('chat_group_members', function (Blueprint $table) {

                    /*
                     * Foreign key may not exist on older versions,
                     * so the column is intentionally left intact.
                     */
                });
            }
        }
    }
};
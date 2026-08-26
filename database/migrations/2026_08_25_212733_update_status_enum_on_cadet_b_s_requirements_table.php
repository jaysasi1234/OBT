<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Temporarily allow both Pending and Submitted
        DB::statement("
            ALTER TABLE cadet_b_s_requirements
            MODIFY status ENUM('Pending', 'Submitted', 'Approved', 'Rejected')
            NOT NULL DEFAULT 'Submitted'
        ");

        // Step 2: Convert existing Pending submissions to Submitted
        DB::table('cadet_b_s_requirements')
            ->where('status', 'Pending')
            ->update([
                'status' => 'Submitted',
            ]);

        // Step 3: Remove Pending from the enum
        DB::statement("
            ALTER TABLE cadet_b_s_requirements
            MODIFY status ENUM('Submitted', 'Approved', 'Rejected')
            NOT NULL DEFAULT 'Submitted'
        ");
    }

    public function down(): void
    {
        // Temporarily allow Pending again
        DB::statement("
            ALTER TABLE cadet_b_s_requirements
            MODIFY status ENUM('Pending', 'Submitted', 'Approved', 'Rejected')
            NOT NULL DEFAULT 'Pending'
        ");

        // Convert Submitted back to Pending when rolling back
        DB::table('cadet_b_s_requirements')
            ->where('status', 'Submitted')
            ->update([
                'status' => 'Pending',
            ]);

        // Restore original enum
        DB::statement("
            ALTER TABLE cadet_b_s_requirements
            MODIFY status ENUM('Pending', 'Approved', 'Rejected')
            NOT NULL DEFAULT 'Pending'
        ");
    }
};
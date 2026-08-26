<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $cadets = DB::table('cadets')->get();

foreach ($cadets as $cadet) {

    // SKIP INVALID DATA
    if (!$cadet->user_id) {
        continue;
    }

    DB::table('deployments')->insert([
        'user_id' => $cadet->user_id,
        'cadet_id' => $cadet->id,

        'status' => $cadet->deployment_status ?? 'Not Started',
        'percentage' => $cadet->deployment_percentage ?? 0,

        'date_deployed' => $cadet->date_deployed,
        'date_disembarked' => $cadet->date_disembarked,

        'company_name' => $cadet->company,
        'notes' => $cadet->remarks,

        'created_at' => now(),
        'updated_at' => now(),
    ]);
}
    }

    public function down(): void
    {
        // rollback NOT recommended for data moves
    }
};
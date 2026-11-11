
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cadet_insurances', function (Blueprint $table) {
            $table->date('expiration_date')->nullable();

            // Prevent duplicate expiration notifications.
            $table->timestamp('expiry_warning_sent_at')->nullable();
            $table->timestamp('expired_notified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('cadet_insurances', function (Blueprint $table) {
            $table->dropColumn([
                'expiration_date',
                'expiry_warning_sent_at',
                'expired_notified_at',
            ]);
        });
    }
};


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->text('company_information')->nullable();
            $table->text('company_address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('shipping_companies', function (Blueprint $table) {
            $table->dropColumn([
                'company_information',
                'company_address',
            ]);
        });
    }
};
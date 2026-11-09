
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obt_policy_acknowledgements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('policy_key');

            $table->timestamp('acknowledged_at')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'policy_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obt_policy_acknowledgements');
    }
};

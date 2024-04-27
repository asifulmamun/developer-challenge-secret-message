<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('seen_status')->default(false); // Default value is false
            $table->timestamp('seen_time')->nullable(); // Nullable timestamp
            $table->timestamp('dlt_time')->nullable(); // Nullable timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('seen_status');
            $table->dropColumn('seen_time');
            $table->dropColumn('dlt_time');
        });
    }
};

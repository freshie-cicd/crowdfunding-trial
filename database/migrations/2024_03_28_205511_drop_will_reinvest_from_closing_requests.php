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
        Schema::table('closing_requests', function (Blueprint $table) {
            $table->dropColumn('will_reinvest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('closing_requests', function (Blueprint $table) {
            // Add the will_reinvest column back if rolling back
            $table->boolean('will_reinvest')->default(false);
            // Adjust this according to your original column specification
        });
    }
};

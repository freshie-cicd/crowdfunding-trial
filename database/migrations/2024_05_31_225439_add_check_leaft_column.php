<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('investor_bank_details', function (Blueprint $table) {
            $table->string('checkbook_url')->nullable()->after('routing_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_bank_details', function (Blueprint $table) {
            $table->dropColumn('checkbook_url');
        });
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active', 'verification_pending', 'blocked', 'suspecious'])->default('verification_pending')->after('date_of_birth');
            $table->dropColumn('is_active');
        });

        DB::table('users')->where('status', 'verification_pending')->update(['status' => 'active']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(1)->after('date_of_birth');
            $table->dropColumn('status');
        });
    }
};

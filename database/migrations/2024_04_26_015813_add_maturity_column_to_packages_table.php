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
        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('maturity')->default(false);
            $table->integer('return_amount')->default(0);
            $table->integer('migration_package_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('maturity');
            $table->dropColumn('return_amount');
            $table->dropColumn('migration_package_id');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};

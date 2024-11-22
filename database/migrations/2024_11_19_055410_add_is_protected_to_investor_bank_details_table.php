<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsProtectedToInvestorBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('investor_bank_details', function (Blueprint $table) {
            $table->boolean('is_protected')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('investor_bank_details', function (Blueprint $table) {
            $table->dropColumn('is_protected');
        });
    }
}

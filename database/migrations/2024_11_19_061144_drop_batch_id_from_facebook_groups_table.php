<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBatchIdFromFacebookGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('facebook_groups', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameBatchIdToProjectIdInClosingInitTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('closing_init', function (Blueprint $table) {
            $table->renameColumn('batch_id', 'project_id');
        });
    }
}

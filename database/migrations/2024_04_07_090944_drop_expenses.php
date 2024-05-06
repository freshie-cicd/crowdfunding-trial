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
        Schema::dropIfExists('expenses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('head');
            $table->string('amount');
            $table->string('submitted_by');
            $table->string('memo')->nullable();
            $table->string('date');
            $table->boolean('is_approved')->default(0);
            $table->string('approved_by');
            $table->enum('type', ['office', 'project', 'others']);
            $table->string('asset_id')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }
};

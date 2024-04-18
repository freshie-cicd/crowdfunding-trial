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
        Schema::dropIfExists('borga_sales');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('borga_sales', function (Blueprint $table) {
            $table->id();
            $table->string('cow_id');
            $table->string('sold_as');
            $table->string('weight');
            $table->string('sell_price');
            $table->string('other_cost');
            $table->string('supervisor');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }
};

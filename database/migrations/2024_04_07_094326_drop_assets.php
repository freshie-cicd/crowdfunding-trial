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
        Schema::dropIfExists('assets');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('package_id');
            $table->string('name');
            $table->string('description');
            $table->string('purchase_price');
            $table->string('color');
            $table->string('location');
            $table->string('asset_code');
            $table->enum('status', ['active', 'inactive', 'dead', 'sick', 'sold'])->default('active');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }
};

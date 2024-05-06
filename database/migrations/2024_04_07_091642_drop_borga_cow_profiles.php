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
        Schema::dropIfExists('borga_cow_profiles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('borga_cow_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('batch_id');
            $table->string('package_id');
            $table->string('cow_code');
            $table->string('purchase_date')->nullable();
            $table->string('price');
            $table->string('hasil');
            $table->string('transport_code');
            $table->string('weight');
            $table->string('color');
            $table->string('breed');
            $table->string('age');
            $table->string('adviser');
            $table->string('hat');
            $table->string('photo')->nullable();
            $table->string('note')->nullable();
            $table->enum('status', ['normal', 'sold', 'lost', 'dead'])->default('normal');
            $table->timestamps();
        });
    }
};

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
        Schema::dropIfExists('expense_heads');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('expense_heads', function (Blueprint $table) {
            $table->id();
            $table->string('parent');
            $table->string('name');
            $table->boolean('status')->default(1);
            $table->string('note');
            $table->timestamps();
        });
    }
};

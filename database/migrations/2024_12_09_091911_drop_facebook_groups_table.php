<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('facebook_groups');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};

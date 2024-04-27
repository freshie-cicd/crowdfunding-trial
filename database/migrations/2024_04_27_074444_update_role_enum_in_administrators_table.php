<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("UPDATE administrators SET role = 'viewer' WHERE role NOT IN ('superadmin', 'customersupport');");
        DB::statement("ALTER TABLE administrators CHANGE COLUMN role role ENUM('superadmin', 'customersupport','viewer') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE administrators SET role = 'viewer' WHERE role NOT IN ('superadmin', 'viewer', 'moderator', 'admin');");
        DB::statement("ALTER TABLE administrators CHANGE COLUMN role role ENUM('viewer', 'moderator', 'admin', 'superadmin') NOT NULL");
    }
};

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
        // MySQL enum modification requires dropping and recreating the column
        DB::statement("ALTER TABLE leases CHANGE COLUMN status status ENUM('active', 'expired', 'cancelled', 'expiring_soon') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE leases CHANGE COLUMN status status ENUM('active', 'expired', 'cancelled') DEFAULT 'active'");
    }
};

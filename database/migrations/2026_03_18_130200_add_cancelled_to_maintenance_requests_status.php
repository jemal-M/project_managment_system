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
        DB::statement("ALTER TABLE maintenance_requests CHANGE COLUMN status status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE maintenance_requests CHANGE COLUMN status status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending'");
    }
};

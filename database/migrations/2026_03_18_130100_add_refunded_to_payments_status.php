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
        DB::statement("ALTER TABLE payments CHANGE COLUMN status status ENUM('pending', 'completed', 'failed', 'refunded')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE payments CHANGE COLUMN status status ENUM('pending', 'completed', 'failed')");
    }
};

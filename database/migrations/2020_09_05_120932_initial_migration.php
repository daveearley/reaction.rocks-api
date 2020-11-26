<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InitialMigration extends Migration
{
    public function up(): void
    {
        DB::unprepared(file_get_contents(__DIR__ . '/schema.sql'));
    }

    public function down(): void
    {
        // No revert
    }
}

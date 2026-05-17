<?php

use Database\Seeders\CategorySeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        CategorySeeder::sync();
    }

    public function down(): void
    {
        // No-op: standaard categorieën worden niet automatisch verwijderd om
        // gekoppelde transacties en merchants intact te houden.
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Per gebruiker één rij met de gepersonaliseerde dashboard-layout.
     * `widgets` is een geordende JSON-array met widget-instanties; de
     * volgorde van de array bepaalt de render-volgorde. Elke entry:
     *   { id, type, hidden, options }
     */
    public function up(): void
    {
        Schema::create('dashboard_layouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->json('widgets');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_layouts');
    }
};

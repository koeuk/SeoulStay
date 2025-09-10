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
        Schema::create('item_attractions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->foreignId('attraction_id')->constrained('attractions')->onDelete('cascade');
            $table->decimal('distance', 8, 2); // in kilometers
            $table->integer('duration_on_foot'); // in minutes
            $table->integer('duration_by_car'); // in minutes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_attractions');
    }
};

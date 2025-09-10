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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('item_type_id')->constrained('item_types')->onDelete('cascade');
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->string('title');
            $table->integer('capacity');
            $table->integer('number_of_beds');
            $table->integer('number_of_bedrooms');
            $table->integer('number_of_bathrooms');
            $table->text('exact_address');
            $table->text('approximate_address');
            $table->text('description');
            $table->json('attributes')->nullable();
            $table->integer('minimum_nights');
            $table->integer('maximum_nights');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

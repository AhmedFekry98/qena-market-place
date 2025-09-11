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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_type_id')->constrained('property_types')->onDelete('cascade');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('address')->nullable();
            $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->decimal('price', 15, 2);
            $table->enum('listing_type', ['rent', 'sell'])->default('rent');
            $table->enum('status', ['available', 'rented', 'sold'])->default('available');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->index(['property_type_id', 'status']);
            $table->index(['city_id', 'status']);
            $table->index(['area_id', 'status']);
            $table->index('created_by');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};

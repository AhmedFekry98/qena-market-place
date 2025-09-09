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
            $table->string('title');
            $table->text('description');
            $table->text('address');
            $table->string('city');
            $table->decimal('price', 15, 2);
            $table->decimal('area', 10, 2);
            $table->enum('status', ['available', 'rented', 'sold'])->default('available');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['property_type_id', 'status']);
            $table->index(['city', 'status']);
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

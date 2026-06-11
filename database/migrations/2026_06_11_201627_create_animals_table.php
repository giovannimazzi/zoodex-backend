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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('dex_number')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('scientific_name')->nullable();
            $table->text('card_image')->nullable();
            $table->text('real_image')->nullable();
            $table->text('description')->nullable();
            $table->decimal('weight_kg', 8, 2)->nullable();
            $table->decimal('length_cm', 8, 2)->nullable();
            $table->decimal('height_cm', 8, 2)->nullable();
            $table->unsignedSmallInteger('lifespan_years')->nullable();
            $table->foreignId('animal_class_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('diet_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('conservation_status_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};

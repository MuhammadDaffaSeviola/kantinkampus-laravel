<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('canteen_id')
                ->constrained('canteens')
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->text('image_url')->nullable();
            $table->decimal('rating', 2, 1)->nullable();
            $table->boolean('is_available')->default(true);

            $table->timestamps();

            $table->index('canteen_id');
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
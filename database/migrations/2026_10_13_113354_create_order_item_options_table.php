<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_item_id')
                ->constrained('order_items')
                ->cascadeOnDelete();

            $table->foreignId('menu_option_id')
                ->constrained('menu_options')
                ->restrictOnDelete();

            $table->decimal('additional_price', 12, 2)->default(0);

            $table->timestamp('created_at')
                ->useCurrent();

            $table->index('order_item_id');
            $table->index('menu_option_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_options');
    }
};
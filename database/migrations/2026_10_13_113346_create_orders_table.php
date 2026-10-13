<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('canteen_id')
                ->constrained('canteens')
                ->restrictOnDelete();

            $table->string('order_number', 30)->unique();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('service_fee', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            $table->string('status', 30)->default('pending');

            $table->timestamp('ordered_at')->useCurrent();

            $table->timestamps();

            $table->index('user_id');
            $table->index('canteen_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
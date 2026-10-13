<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('canteens', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('location', 150);
            $table->string('building', 100)->nullable();
            $table->string('status', 20)->default('open');
            $table->integer('queue_density')->default(0);
            $table->integer('estimated_wait_minutes')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteens');
    }
};
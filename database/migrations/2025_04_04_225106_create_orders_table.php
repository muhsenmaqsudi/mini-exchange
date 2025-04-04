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
        Schema::create('orders', function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'id')->primary();
            $table->unsignedBigInteger(column: 'user_id');
            $table->unsignedBigInteger(column: 'coin_id');
            $table->uuid(column: 'idempotency_key');
            $table->enum(column: 'direction', allowed: ['BUY', 'SELL']);
            $table->enum(column: 'type', allowed: ['SPOT', 'FUTURES', 'OTC']);
            $table->decimal(column: 'price', total: 18, places: 8);
            $table->decimal(column: 'volume', total: 18, places: 8);
            $table->enum('status', allowed: ['PENDING', 'MATCHED', 'CANCELED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

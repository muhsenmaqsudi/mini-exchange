<?php

use App\ValueObjects\TradeSide;
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
        Schema::create('trades', function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'id')->primary();
            $table->unsignedBigInteger(column: 'user_id')->index();
            $table->unsignedBigInteger(column: 'coin_id')->index();
            $table->enum(column: 'side', allowed: TradeSide::values());
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('counter_order_id');
            $table->decimal(column: 'price', total: 18, places: 8);
            $table->decimal(column: 'volume', total: 18, places: 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};

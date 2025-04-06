<?php

namespace App\Services;

use App\Concerns\Makeable;
use App\Models\Order;
use App\Models\Trade;
use App\ValueObjects\OrderStatus;
use App\ValueObjects\TradeSide;
use Illuminate\Support\Facades\DB;

class OrderMatchingService
{
    use Makeable;

    public function match(Order $newOrder): void
    {
        if ($newOrder->status !== OrderStatus::OPEN) {
            return;
        }

        $matchingOrder = Order::query()
            ->where('direction', $newOrder->direction->opposite())
            ->where('coin_id', $newOrder->coin_id)
            ->where('price', $newOrder->price)
            ->where('volume', $newOrder->volume)
            ->where('status', OrderStatus::OPEN)
            ->orderBy('created_at', 'asc') // First-in-first-out
            ->first();

        if (!$matchingOrder) {
            return;
        }

        $this->executeTrade($newOrder, $matchingOrder);
    }

    private function executeTrade(Order $newOrder, Order $matchingOrder): void
    {
        DB::transaction(function () use ($newOrder, $matchingOrder) {
            // Determine taker (aggressive order) and maker (resting order)
            $isNewOrderTaker = $newOrder->created_at > $matchingOrder->created_at;
            $takerOrder = $isNewOrderTaker ? $newOrder : $matchingOrder;
            $makerOrder = $isNewOrderTaker ? $matchingOrder : $newOrder;

            Trade::create([
                'user_id' => $takerOrder->user_id,
                'coin_id' => $takerOrder->coin_id,
                'taker_order_id' => $takerOrder->id,
                'maker_order_id' => $makerOrder->id,
                'side' => TradeSide::TAKER,
                'price' => $makerOrder->price,
                'volume' => $takerOrder->volume,
            ]);

            Trade::create([
                'user_id' => $makerOrder->user_id,
                'coin_id' => $makerOrder->coin_id,
                'taker_order_id' => $takerOrder->id,
                'maker_order_id' => $makerOrder->id,
                'side' => TradeSide::MAKER,
                'price' => $makerOrder->price,
                'volume' => $makerOrder->volume,
            ]);

            $newOrder->status = OrderStatus::MATCHED;
            $matchingOrder->status = OrderStatus::MATCHED;
            
            $newOrder->save();
            $matchingOrder->save();
        });
    }
}
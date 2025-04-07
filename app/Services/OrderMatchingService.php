<?php

namespace App\Services;

use App\Concerns\Makeable;
use App\Models\Order;
use App\Models\Trade;
use App\ValueObjects\OrderDirection;
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
            ->orderBy('created_at', 'asc')
            ->lockForUpdate()
            ->first();

        if (!$matchingOrder) {
            return;
        }

        $this->executeTrade($newOrder, $matchingOrder);
    }

    private function executeTrade(Order $newOrder, Order $matchingOrder): void
    {
        DB::transaction(function () use ($newOrder, $matchingOrder) {
            $isNewOrderTaker = $newOrder->created_at > $matchingOrder->created_at;
            $takerOrder = $isNewOrderTaker ? $newOrder : $matchingOrder;
            $makerOrder = $isNewOrderTaker ? $matchingOrder : $newOrder;

            $takerSide = $takerOrder->direction === OrderDirection::BUY
                ? TradeSide::BUY_TAKER
                : TradeSide::SELL_TAKER;

            $makerSide = $makerOrder->direction === OrderDirection::BUY
                ? TradeSide::BUY_MAKER
                : TradeSide::SELL_MAKER;

            Trade::create([
                'user_id' => $takerOrder->user_id,
                'coin_id' => $takerOrder->coin_id,
                'order_id' => $takerOrder->id,
                'counter_order_id' => $makerOrder->id,
                'side' => $takerSide,
                'price' => $makerOrder->price,
                'volume' => $takerOrder->volume,
            ]);

            Trade::create([
                'user_id' => $makerOrder->user_id,
                'coin_id' => $makerOrder->coin_id,
                'order_id' => $makerOrder->id,
                'counter_order_id' => $takerOrder->id,
                'side' => $makerSide,
                'price' => $makerOrder->price,
                'volume' => $makerOrder->volume,
            ]);

            $newOrder->status = OrderStatus::FILLED;
            $matchingOrder->status = OrderStatus::FILLED;

            $newOrder->save();
            $matchingOrder->save();
        });
    }
}

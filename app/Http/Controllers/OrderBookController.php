<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\ValueObjects\OrderDirection;
use App\ValueObjects\OrderStatus;
use Illuminate\Http\JsonResponse;

class OrderBookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $bids = Order::query()
            ->selectRaw(expression: 'price, SUM(volume) AS volume, CAST(price * SUM(volume) AS VARCHAR) AS sum')
            ->where(column: 'status', operator: '=', value: OrderStatus::OPEN)
            ->where(column: 'direction', operator: '=', value: OrderDirection::BUY)
            ->orderBy(column: 'price', direction: 'desc')
            ->take(value: 40)
            ->groupBy('price')
            ->get();

        $asks = Order::query()
            ->selectRaw(expression: 'price, SUM(volume) AS volume, CAST(price * SUM(volume) AS VARCHAR) AS sum')
            ->where(column: 'status', operator: '=', value: OrderStatus::OPEN)
            ->where(column: 'direction', operator: '=', value: OrderDirection::SELL)
            ->orderBy(column: 'price')
            ->take(value: 40)
            ->groupBy('price')
            ->get();

        return response()->json(data: [
            'data' => [
                'bids' => $bids,
                'asks' => $asks,
            ]
        ]);
    }
}

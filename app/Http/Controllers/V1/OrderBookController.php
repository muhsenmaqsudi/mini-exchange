<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\ValueObjects\OrderDirection;
use App\ValueObjects\OrderStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderBookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): JsonResponse
    {
        $bids = DB::select("
            WITH price_volume_cte AS (
                SELECT 
                    price, 
                    SUM(volume) AS volume
                FROM orders
                WHERE status = ? AND direction = ?
                GROUP BY price
            )
            SELECT 
                price, 
                volume, 
                (price * volume)::VARCHAR AS sum
            FROM price_volume_cte
            ORDER BY price DESC
            LIMIT 40
        ", [OrderStatus::OPEN->value, OrderDirection::BUY->value]);

        $asks = DB::select("
            WITH price_volume_cte AS (
                SELECT 
                    price, 
                    SUM(volume) AS volume
                FROM orders
                WHERE status = ? AND direction = ?
                GROUP BY price
            )
            SELECT 
                price, 
                volume, 
                (price * volume)::VARCHAR AS sum
            FROM price_volume_cte
            ORDER BY price DESC
            LIMIT 40
        ", [OrderStatus::OPEN->value, OrderDirection::SELL->value]);

        return response()->json(data: [
            'data' => [
                'bids' => $bids,
                'asks' => $asks,
            ]
        ]);
    }
}

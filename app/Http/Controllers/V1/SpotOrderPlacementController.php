<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SpotOrderPlacementRequest;
use App\Models\Coin;
use App\Models\Order;
use App\ValueObjects\OrderStatus;
use Illuminate\Support\Facades\Auth;

class SpotOrderPlacementController extends Controller
{
    public function __invoke(SpotOrderPlacementRequest $request)
    {
        $orderDTO = $request->toDTO();

        $coin = Coin::query()->where(column: 'symbol', operator: '=', value: $orderDTO->symbol)->first();

        if (!$coin) {
            throw new \Exception(message: 'Invalid symbol provided');
        }

        $orderData = [
            'user_id' => Auth::id(),
            'coin_id' => $coin->id,
            'status' => OrderStatus::OPEN,
        ];

        $orderDTO->merge(data: $orderData);

        $order = Order::query()->create(attributes: $orderDTO->toArray());

        return response()->json(data: $order);
    }
}

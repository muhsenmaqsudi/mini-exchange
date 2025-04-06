<?php

namespace App\Actions;

use App\Concerns\Makeable;
use App\Http\DataObjects\SpotOrderPlacementDTO;
use App\Models\Order;
use App\ValueObjects\OrderStatus;
use Illuminate\Support\Facades\Auth;

class StoreSpotOrderAction
{
    use Makeable;

    public function handle(SpotOrderPlacementDTO $dto)
    {
        $orderData = [
            'user_id' => Auth::id(),
            'status' => OrderStatus::OPEN,
        ];

        $dto->merge(data: $orderData);

        return Order::query()->create(attributes: $dto->toArray());
    }
}

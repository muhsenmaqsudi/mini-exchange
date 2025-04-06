<?php

namespace App\Http\Controllers\V1;

use App\Actions\StoreSpotOrderAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SpotOrderPlacementRequest;
use App\Http\Validators\SpotOrderValidator;
use App\Models\Coin;

class SpotOrderPlacementController extends Controller
{
    /**
     * @throws \Exception
     */
    public function __invoke(SpotOrderPlacementRequest $request)
    {
        $orderDTO = $request->toDTO();

        $coin = Coin::query()
            ->where(column: 'symbol', operator: '=', value: $orderDTO->symbol)
            ->first();

        $orderDTO->setCoin(coin: $coin);

        $spotOrderValidator = new SpotOrderValidator(dto: $orderDTO);

        if (! $spotOrderValidator->isProvidedSymbolCorrect()) {
            throw new \Exception(message: 'Invalid symbol provided');
        }

        try {
            $order = StoreSpotOrderAction::make()->handle(dto: $orderDTO);
        } catch (\Throwable $th) {
            throw new \Exception(message: 'Query exception');
        }

        return response()->json(data: $order);
    }
}

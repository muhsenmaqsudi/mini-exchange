<?php

namespace App\Http\DataObjects;

use App\Models\Coin;
use App\ValueObjects\OrderDirection;
use App\ValueObjects\OrderType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class SpotOrderPlacementDTO implements Arrayable
{
    protected array $mergedData = [];

    protected ?Coin $coin;

    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $symbol,
        public OrderDirection $direction,
        public OrderType $type,
        public string $price,
        public string $volume,
        public ?string $idempotencyKey = null,
    ) {}

    public function toArray(): array
    {
        return [
            'direction' => $this->direction,
            'type' => $this->type,
            'price' => $this->price,
            'volume' => $this->volume,
            'idempotency_key' => $this->idempotencyKey ?? Str::uuid(),
            'coin_id' => $this->coin->id,
            ...$this->mergedData,
        ];
    }

    public function merge(array $data): void
    {
        $this->mergedData = $data;
    }

    public function setCoin(?Coin $coin): void
    {
        $this->coin = $coin;
    }

    public function getCoin(): ?Coin
    {
        return $this->coin;
    }
}

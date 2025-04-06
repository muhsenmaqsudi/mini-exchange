<?php

namespace App\Http\Validators;

use App\Http\DataObjects\SpotOrderPlacementDTO;

class SpotOrderValidator
{
    public function __construct(
        public SpotOrderPlacementDTO $dto
    ) {}

    public function isProvidedSymbolCorrect(): bool
    {
        return (bool) $this->dto->getCoin();
    }
}

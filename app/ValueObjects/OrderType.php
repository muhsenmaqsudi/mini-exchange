<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderType: string
{
    use InteractsWithEnum;

    case SPOT = 'spot';
    case FUTURES = 'futures';
    case LIMIT = 'limit';
    case OTC = 'otc';

    public function isSpot(): bool
    {
        return $this === self::SPOT;
    }

    public function isFutures(): bool
    {
        return $this === self::FUTURES;
    }

    public function isLimit(): bool
    {
        return $this === self::LIMIT;
    }

    public function isOTC(): bool
    {
        return $this === self::OTC;
    }
}

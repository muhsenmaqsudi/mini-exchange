<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderDirection: string
{
    use InteractsWithEnum;

    case BUY = 'buy';
    case SELL = 'sell';

    public function opposite(): self
    {
        return $this === self::BUY ? self::SELL : self::BUY;
    }
}

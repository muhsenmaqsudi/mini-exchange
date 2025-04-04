<?php

namespace App\ValueObjects;

enum OrderDirection: string
{
    case BUY = 'buy';
    case SELL = 'sell';

    public function opposite(): self
    {
        return $this === self::BUY ? self::SELL : self::BUY;
    }
}

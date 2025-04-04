<?php

namespace App\ValueObjects;

enum TradeSide: string
{
    case MAKER = 'maker';
    case TAKER = 'taker';

    public function isMaker(): bool
    {
        return $this === self::MAKER;
    }

    public function isTaker(): bool
    {
        return $this === self::TAKER;
    }

    public function opposite(): self
    {
        return $this === self::MAKER ? self::TAKER : self::MAKER;
    }
}

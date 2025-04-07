<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum TradeSide: string
{
    use InteractsWithEnum;

    case BUY_TAKER = 'BUY_TAKER';
    case BUY_MAKER = 'BUY_MAKER';
    case SELL_TAKER = 'SELL_TAKER';
    case SELL_MAKER = 'SELL_MAKER';

    public function isMaker(): bool
    {
        return $this === self::BUY_MAKER || $this === self::SELL_MAKER;
    }

    public function isTaker(): bool
    {
        return $this === self::BUY_TAKER || $this === self::BUY_MAKER;
    }
}

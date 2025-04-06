<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderType: string
{
    use InteractsWithEnum;

    case LIMIT = 'LIMIT';
    case MARKET = 'MARKET';
    case STOP_LIMIT = 'STOP_LIMIT';
    case STOP_MARKET = 'STOP_MARKET';
    case TAKE_PROFIT_MARKET = 'TAKE_PROFIT_MARKET';
    case TAKE_PROFIT_LIMIT = 'TAKE_PROFIT_LIMIT';
    case TRAILING_STOP_MARKET = 'TRAILING_STOP_MARKET';

    public function isMarket()
    {
        return in_array(needle: $this, haystack: [
            self::MARKET, 
            self::STOP_MARKET, 
            self::TAKE_PROFIT_MARKET, 
            self::TRAILING_STOP_MARKET
        ]);
    }

    public function isLimit(): bool
    {
        return in_array(needle: $this, haystack: [
            self::LIMIT, 
            self::STOP_LIMIT, 
            self::TAKE_PROFIT_LIMIT,
        ]);
    }
}

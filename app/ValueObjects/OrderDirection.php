<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderDirection: string
{
    use InteractsWithEnum;

    case BUY = 'BUY';
    case SELL = 'SELL';

    public function opposite(): self
    {
        return $this === self::BUY ? self::SELL : self::BUY;
    }

    public function ordering()
    {
        return $this === self::BUY ? 'desc' : 'asc';
    }

    public function filtering()
    {
        return $this === self::BUY ? '<=' : '>=';
    }
}

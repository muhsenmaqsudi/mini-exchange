<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderStatus: string
{
    use InteractsWithEnum;
    
    case OPEN = 'OPEN';
    case MATCHED = 'MATCHED';
    case PARTIALLY_MATCHED = 'PARTIALLY_MATCHED';
    case CANCELED = 'CANCELED';

    public function isOpen(): bool
    {
        return $this === self::OPEN;
    }
    
    public function isMatched(): bool
    {
        return $this === self::MATCHED;
    }

    public function isPartiallyMatched(): bool
    {
        return $this === self::PARTIALLY_MATCHED;
    }

    public function isCanceled(): bool
    {
        return $this === self::CANCELED;
    }
}

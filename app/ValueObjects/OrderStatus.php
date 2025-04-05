<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderStatus: string
{
    use InteractsWithEnum;
    
    case OPEN = 'open';
    case MATCHED = 'matched';
    case PARTIALLY_MATCHED = 'partially_matched';
    case CANCELED = 'canceled';

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

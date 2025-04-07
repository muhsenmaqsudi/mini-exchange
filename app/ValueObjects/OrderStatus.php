<?php

namespace App\ValueObjects;

use App\Concerns\InteractsWithEnum;

enum OrderStatus: string
{
    use InteractsWithEnum;
    
    case OPEN = 'OPEN';
    case FILLED = 'FILLED';
    case PARTIALLY_FILLED = 'PARTIALLY_FILLED';
    case CANCELED = 'CANCELED';

    public function isOpen(): bool
    {
        return $this === self::OPEN;
    }
    
    public function isFilled(): bool
    {
        return $this === self::FILLED;
    }

    public function isPartiallyFilled(): bool
    {
        return $this === self::PARTIALLY_FILLED;
    }

    public function isCanceled(): bool
    {
        return $this === self::CANCELED;
    }
}

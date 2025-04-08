<?php

namespace App\Exceptions;

use App\ValueObjects\HttpStatus;

class InvalidSymbolProvidedException extends InternalException
{
    protected $code = HttpStatus::BAD_REQUEST->value;
    protected mixed $internalCode = ExceptionCode::INVALID_SYMBOL;
}

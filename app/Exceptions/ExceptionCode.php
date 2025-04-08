<?php

namespace App\Exceptions;

use App\Attributes\ExceptionMeta;
use App\Concerns\HasExceptionMetaAttribute;

enum ExceptionCode: int
{
    use HasExceptionMetaAttribute;

    #[ExceptionMeta(
        id: 'unauthenticated_exception',
        message: 'You must be authenticated to access this api.',
    )]
    case UNAUTHORIZED = 40001;

    #[ExceptionMeta(
        id: 'not_found_exception',
        message: 'Your requested resource does not exist.',
    )]
    case NOT_FOUND = 40002;

    #[ExceptionMeta(
        id: 'validation_exception',
        message: 'Invalid data provided, fix mentioned errors and try again.',
    )]
    case VALIDATION = 40003;

    #[ExceptionMeta(
        id: 'invalid_symbol',
        message: 'Invalid symbol provided',
    )]
    case INVALID_SYMBOL = 40005;

    #[ExceptionMeta(
        id: 'internal_exception',
        message: 'internal server error, please try again later.',
    )]
    case INTERNAL = 50001;
}

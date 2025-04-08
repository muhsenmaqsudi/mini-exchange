<?php

namespace App\Exceptions;

use App\Http\Responses\ApiErrorResponse;
use App\ValueObjects\HttpStatus;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

/** @phpstan-consistent-constructor */
class InternalException extends Exception
{
    protected mixed $internalCode = ExceptionCode::INTERNAL;

    protected string $supportId;
    protected string $help = 'https://wallex.ir/help';

    public function __construct(?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? $this->internalCode->message(), $code, $previous);

        $this->supportId = Str::uuid()->toString();
    }

    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return true;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): ApiErrorResponse
    {
        return new ApiErrorResponse(exception: $this);
    }

    public static function new(
        mixed $code,
        ?HttpStatus $statusCode = null,
        ?string $message = null,
        ?string $supportId = null,
        ?string $help = 'https://wallex.ir',
        ?Throwable $previous = null
    ): static {
        $exception = new static(
            message: $message ?? $code->getMessage(),
            code: $statusCode->value ?? $code->getStatusCode(),
            previous: $previous
        );

        $exception->internalCode = $code;
        $exception->supportId = $supportId ?? Str::uuid()->toString();
        $exception->help = $help;

        return $exception;
    }

    public function getInternalCode(): mixed
    {
        return $this->internalCode;
    }

    public function getSupportId(): string
    {
        return $this->supportId;
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function shouldRetry(): int
    {
        return in_array(substr($this->internalCode->value, 0, 1), [2, 5]) ? 0 : 1;
    }
}

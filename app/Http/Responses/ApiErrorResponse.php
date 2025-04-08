<?php

namespace App\Http\Responses;

use App\Exceptions\InternalException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

readonly class ApiErrorResponse implements Responsable
{
    private InternalException $exception;

    public function __construct(InternalException $exception)
    {
        $this->exception = $exception;
    }

    public function toResponse($request): JsonResponse
    {
        return response()
            ->json([
                'id' => $this->exception->getInternalCode()->id(),
                'code' => $this->exception->getInternalCode()->value,
                'message' => $this->exception->getPrevious() && config('app.env') !== 'production'
                    ? $this->exception->getPrevious()->getMessage()
                    : $this->exception->getMessage(),
                'trace_id' => $this->exception->getSupportId(), //backing
                'links' => [
                    'doc' => $this->exception->getHelp(),
                    'support' => 'https://bot.wallex.ir/'.$this->exception->getSupportId(),
                ],
            ])
            ->withHeaders([
                'Should-Retry' => $this->exception->shouldRetry(),
            ])
            ->setStatusCode($this->exception->getCode());
    }
}

<?php

namespace App\Exceptions;

use App\ValueObjects\HttpStatus;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionHandler
{
    public static function setExceptionCallbacks(Exceptions $exceptions): void
    {
        $exceptions->shouldRenderJsonWhen(fn (Request $request, Throwable $e) => $request->expectsJson());

        $exceptions->renderable(function (HttpExceptionInterface $e) {
            $errorResponse = match (get_class($e)) {
                NotFoundHttpException::class => [
                    'id' => ExceptionCode::NOT_FOUND->id(),
                    'code' => ExceptionCode::NOT_FOUND->value,
                    'message' => ExceptionCode::NOT_FOUND->message(),
                ],
                default => [
                    'id' => ExceptionCode::INTERNAL->id(),
                    'code' => ExceptionCode::INTERNAL->value,
                    'message' => app()->isProduction()
                        ? ExceptionCode::INTERNAL->message()
                        : $e->getMessage(),
                ],
            };

            return response()
                ->json($errorResponse)
                ->setStatusCode($errorResponse['code'] === HttpStatus ::INTERNAL_SERVER_ERROR
                    ? HttpStatus::INTERNAL_SERVER_ERROR->value
                    : $e->getStatusCode()
                );
        });

        // validation exc
        $exceptions->renderable(function (ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()
                    ->json([
                        'id' => ExceptionCode::VALIDATION->id(),
                        'code' => ExceptionCode::VALIDATION->value,
                        'message' => ExceptionCode::VALIDATION->message(),
                        'errors' => $e->errors(),
                    ])
                    ->setStatusCode(HttpStatus::UNPROCESSABLE_CONTENT->value);
            }

            return redirect()->back()->withInput()->withErrors($e->errors());
        });

        // default ones
        $exceptions->renderable(function (AuthenticationException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()
                    ->json([
                        'id' => ExceptionCode::UNAUTHORIZED->id(),
                        'code' => ExceptionCode::UNAUTHORIZED->value,
                        'message' => ExceptionCode::UNAUTHORIZED->message(),
                    ])
                    ->setStatusCode(HttpStatus::UNAUTHORIZED->value);
            }
        });

        $exceptions->renderable(function (Throwable $e, Request $request) {
            if ($request->wantsJson()) {
                return response()
                    ->json([
                        'id' => ExceptionCode::INTERNAL->id(),
                        'code' => ExceptionCode::INTERNAL->value,
                        'message' => ExceptionCode::INTERNAL->message(),
                    ])
                    ->setStatusCode(HttpStatus::INTERNAL_SERVER_ERROR->value);
            }
        });
    }
}

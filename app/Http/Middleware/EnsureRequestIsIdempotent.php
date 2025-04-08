<?php

namespace App\Http\Middleware;

use App\ValueObjects\HttpMethod;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

class EnsureRequestIsIdempotent implements TerminableInterface
{
    public const string IDEMPOTENT_KEY = 'X-Idempotency-Key';
    public const string IDEMPOTENT_REPLY = 'X-Idempotent-Replayed';

    public const string IN_PROGRESS = 'X-Idempotency-InProgress';

    public bool $isProcessing = false;

    private ?string $idempotentId;
    private bool $isIdempotent = false;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     *
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->method() == HttpMethod::POST->value) {
            return $next($request);
        }

        if (! ($this->isIdempotent = $request->hasHeader(static::IDEMPOTENT_KEY))) {
            return $next($request);
        }

        $this->idempotentId = $request->fingerprint().':'.$request->header(static::IDEMPOTENT_KEY);

        if (filled($idmResponse = Cache::get($this->idempotentId))) {
            if ($idmResponse instanceof Response) {
                return $idmResponse;
            }

            $this->isProcessing = true;
            throw new \Exception('your request is already in progress be patient');
        }

        Cache::put($this->idempotentId, static::IN_PROGRESS, now()->addMinute());

        return $next($request);
    }

    public function terminate(HttpFoundationRequest $request, Response $response): void
    {
        if (! $this->isIdempotent || $response->headers->has(static::IDEMPOTENT_REPLY)) {
            return;
        }

        if (! $response->isSuccessful() && ! $this->isProcessing) {
            Cache::delete($this->idempotentId);

            return;
        }

        if ($response->isSuccessful()) {
            $response->headers->add([
                static::IDEMPOTENT_REPLY => true,
            ]);
            Cache::put($this->idempotentId, $response, now()->addHour());
        }
    }
}

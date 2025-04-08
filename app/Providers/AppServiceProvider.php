<?php

namespace App\Providers;

use App\Http\Middleware\EnsureRequestIsIdempotent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        EnsureRequestIsIdempotent::class => EnsureRequestIsIdempotent::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

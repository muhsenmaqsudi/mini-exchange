<?php

namespace App\Concerns;

trait Makeable
{
    public static function make(): static
    {
        return app(abstract: static::class);
    }

    /**
     * @see static::handle()
     *
     * @param  mixed  ...$arguments
     */
    public static function run(...$arguments): mixed
    {
        return static::make()->handle(...$arguments);
    }
}

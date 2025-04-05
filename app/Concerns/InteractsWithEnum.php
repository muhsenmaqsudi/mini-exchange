<?php

namespace App\Concerns;

trait InteractsWithEnum
{
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    public static function toArray(): array
    {
        return array_combine(static::values(), static::names());
    }

    public static function toJson(): string
    {
        return json_encode(value: static::toArray(), flags: JSON_PRETTY_PRINT);
    }

    public static function implodes(?string $separator = ','): string
    {
        return implode(separator: $separator, array: static::values());
    }

    public static function isValueIn(array|string|int $needle): bool
    {
        $values = self::values();

        if (! is_array($needle)) {
            return in_array((string) $needle, $values);
        }

        return empty(array_diff($needle, $values));
    }

    public static function isNotValueIn(array|string|int $needle): bool
    {
        return ! self::isValueIn($needle);
    }
}

<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AsJson implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (is_null(value: $value)) {
            return null;
        }

        return json_decode(json: $value, associative: true);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {        
        if (is_null(value: $value)) {
            return null;
        }

        if (is_array(value: $value) || is_object(value: $value)) {
            return json_encode(value: $value);
        }

        if (is_string(value: $value)) {
            json_decode(json: $value);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $value;
            }
        }

        throw new InvalidArgumentException(
            "Value for key '{$key}' must be a valid JSON string, array, or object."
        );
    }
}

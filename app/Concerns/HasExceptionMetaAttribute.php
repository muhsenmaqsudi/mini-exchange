<?php

namespace App\Concerns;

use App\Attributes\ExceptionMeta;
use ReflectionClassConstant;

trait HasExceptionMetaAttribute
{
    public function id(): string
    {
        $attributes = (new ReflectionClassConstant(
            class: self::class,
            constant: $this->name,
        ))->getAttributes(
            name: ExceptionMeta::class,
        );

        if ($attributes === []) {
            throw new \RuntimeException(
                message: 'No case exception meta attribute found for '.$this->name,
            );
        }

        return $attributes[0]->newInstance()->id;
    }

    public function message(): string
    {
        $attributes = (new ReflectionClassConstant(
            class: self::class,
            constant: $this->name,
        ))->getAttributes(
            name: ExceptionMeta::class,
        );

        if ($attributes === []) {
            throw new \RuntimeException(
                message: 'No case exception meta attribute found for '.$this->name,
            );
        }

        return $attributes[0]->newInstance()->message;
    }

    public function translate(): string
    {
        $attributes = (new ReflectionClassConstant(
            class: self::class,
            constant: $this->name,
        ))->getAttributes(
            name: ExceptionMeta::class,
        );

        if ($attributes === []) {
            throw new \RuntimeException(
                message: 'No case exception meta attribute found for '.$this->name,
            );
        }

        return __($attributes[0]->newInstance()->message);
    }
}

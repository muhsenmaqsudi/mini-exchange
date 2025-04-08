<?php

namespace App\Attributes;

use Attribute;

#[Attribute]
final readonly class ExceptionMeta
{
    public function __construct(
        public string $id,
        public string $message,
    ) {}
}

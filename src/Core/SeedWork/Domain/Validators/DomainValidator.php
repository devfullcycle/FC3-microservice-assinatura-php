<?php

namespace Core\SeedWork\Domain\Validators;

class DomainValidator
{
    public static function notNull(?string $value = null): void
    {
        if (empty($value)) {
            throw new \Exception('Should not be empty');
        }
    }
}

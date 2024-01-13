<?php

namespace Core\SeedWork\Domain\Validators;

use Core\SeedWork\Domain\Exceptions\EntityValidationException;

class DomainValidator
{
    public static function notNull(?string $value = null, ?string $exceptionMessage = null): void
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptionMessage ?? 'Should not be empty');
        }
    }

    public static function strMaxLength(string $value = ''): void
    {
        if (strlen($value) >= 255) {
            throw new EntityValidationException('The value must not be greater than 255 characters');
        }
    }
}

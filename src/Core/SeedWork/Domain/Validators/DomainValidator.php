<?php

namespace Core\SeedWork\Domain\Validators;

use Core\SeedWork\Domain\Exceptions\EntityValidation;

class DomainValidator
{
    public static function notNull(?string $value = null): void
    {
        if (empty($value)) {
            throw new EntityValidation('Should not be empty');
        }
    }
}

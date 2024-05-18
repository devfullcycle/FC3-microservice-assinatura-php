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

    public static function strMaxLength(string $value = '', int $length = 255, ?string $exceptionMessage = null): void
    {
        if (strlen($value) > $length) {
            throw new EntityValidationException($exceptionMessage ?? "The value must not be greater than {$length} characters");
        }
    }

    public static function strMinLength(string $value = '', int $length = 3, ?string $exceptionMessage = null): void
    {
        if (strlen($value) < $length) {
            throw new EntityValidationException($exceptionMessage ?? "The value must be at least {$length} characters");
        }
    }

    public static function strCanNullAndMaxLength(?string $value = null, int $length = 255, ?string $exceptionMessage = null): void
    {
        if (! empty($value) && strlen($value) > $length) {
            throw new EntityValidationException($exceptionMessage ?? "The value must not be greater than {$length} characters");
        }
    }

    public static function ageIsValid(int $age, ?string $exceptionMessage = null): void
    {
        if (! ($age > 0 && $age < 150)) {
            throw new EntityValidationException($exceptionMessage ?? "The age is invalid");
        }
    }
}

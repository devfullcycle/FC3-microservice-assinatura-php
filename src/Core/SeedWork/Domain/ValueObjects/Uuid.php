<?php

namespace Core\SeedWork\Domain\ValueObjects;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    public function __construct(
        protected string $value,
    ) {
        $this->ensureIsValid($value);
    }

    public static function random(): self
    {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function ensureIsValid(string $value): void
    {
        if (!RamseyUuid::isValid($value)) {
            throw new InvalidArgumentException(sprintf("<%s> does not allow the value <%s>", static::class, $value));
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

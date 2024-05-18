<?php

namespace Core\SeedWork\Domain\ValueObjects;

use InvalidArgumentException;

class Address
{
    public function __construct(
        protected string $street,
        protected string $city,
        protected string $state,
        protected string $country,
        protected string $zipCode,
        protected ?string $number = null,
    ) {
        $this->ensureIsValid();
    }

    public function ensureIsValid(): void
    {
        if (
            strlen($this->street) <= 2 ||
            strlen($this->city) <= 2 ||
            strlen($this->state) <= 2 ||
            strlen($this->country) <= 2 ||
            strlen($this->zipCode) <= 8
        ) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value', static::class));
        }
    }

    public function __get(string $property): string
    {
        return $this->{$property};
    }
}

<?php

namespace Core\Plan\Domain;

use Core\SeedWork\Domain\ValueObjects\Uuid;

class Plan
{
    public function __construct(
        protected ?Uuid $id = null,
        protected string $name,
        protected string $description,
    ) {
        $this->id = $this->id ?? Uuid::random();
    }
    
    public function __get($property)
    {
        return $this->{$property};
    }

    public function id(): string
    {
        return $this->id;
    }
}

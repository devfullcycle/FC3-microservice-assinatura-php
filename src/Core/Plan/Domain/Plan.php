<?php

namespace Core\Plan\Domain;

use Core\SeedWork\Domain\Validators\DomainValidator;
use Core\SeedWork\Domain\ValueObjects\Uuid;

class Plan
{
    public function __construct(
        protected string $name,
        protected string $description,
        protected ?Uuid $id = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->validate();
    }
    
    public function __get($property)
    {
        return $this->{$property};
    }

    public function id(): string
    {
        return $this->id;
    }

    public function update(string $name, ?string $description = null): void
    {
        $this->name = $name;
        $this->description = $description ?? $this->description;

        $this->validate();
    }

    private function validate(): void
    {
        DomainValidator::strMinLength($this->name);
        DomainValidator::strMaxLength($this->name);
        DomainValidator::strMaxLength(
            value: $this->description,
            length: 10000
        );
        DomainValidator::strMinLength(
            value: $this->description,
            length: 5
        );
    }
}

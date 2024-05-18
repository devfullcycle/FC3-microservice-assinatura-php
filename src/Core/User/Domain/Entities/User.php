<?php

namespace Core\User\Domain\Entities;

use Core\SeedWork\Domain\Traits\MethodsMagicTrait;
use Core\SeedWork\Domain\Validators\DomainValidator;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\SeedWork\Domain\ValueObjects\Uuid;

class User
{
    use MethodsMagicTrait;

    public function __construct(
        protected string $name,
        protected string $lastName,
        protected int $age,
        protected Address $address,
        protected CpfVO|CnpjVO $type,
        protected ?Uuid $id = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->validate();
    }

    public function update(string $name, string $lastName, ?int $age = null): void
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->age = $age ?? $this->age;

        $this->validate();
    }

    public function fullName(): string
    {
        return $this->name.' '.$this->lastName;
    }

    private function validate(): void
    {
        DomainValidator::strMinLength($this->name);
        DomainValidator::strMinLength($this->lastName);
        DomainValidator::strMaxLength($this->name);
        DomainValidator::strMaxLength($this->lastName);
        DomainValidator::ageIsValid($this->age);
    }
}

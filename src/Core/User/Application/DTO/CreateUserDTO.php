<?php

namespace Core\User\Application\DTO;

use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;

readonly class CreateUserDTO
{
    public function __construct(
        public string $name,
        public string $lastName,
        public int $age,
        public Address $address,
        public CpfVO|CnpjVO $type,
    ) {
    }
}

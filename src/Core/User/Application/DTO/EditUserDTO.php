<?php

namespace Core\User\Application\DTO;

use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CnpjVO;
use Core\SeedWork\Domain\ValueObjects\CpfVO;

readonly class EditUserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $lastName,
        public ?int $age = null
    ) {
    }
}

<?php

namespace Core\User\Application\DTO;

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

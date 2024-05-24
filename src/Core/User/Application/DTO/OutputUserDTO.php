<?php

namespace Core\User\Application\DTO;

use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\User\Domain\Entities\User;

readonly class OutputUserDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $last_name,
        public string $full_name,
        public int $age,
        public string $type,
        public string $document,
        public array $address
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->id(),
            name: $user->name,
            last_name: $user->lastName,
            full_name: $user->fullName(),
            age: $user->age,
            type: $user->type instanceof CpfVO ? 'cpf' : 'cnpj',
            document: (string) $user->type,
            address: [
                'city' => $user->address->city,
                'state' => $user->address->state,
                'country' => $user->address->country,
                'zip_code' => $user->address->zipCode,
                'street' => $user->address->street,
                'number' => $user->address->number,
            ],
        );
    }
}

<?php

namespace Core\User\Application\DTO;

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
        public array $address
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->id(),
            name: $user->name,
            last_name: $user->last_name,
            full_name: $user->fullName(),
            age: $user->age,
            type: $user->type->value,
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

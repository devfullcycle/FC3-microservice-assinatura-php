<?php

namespace Core\User\Domain\Events;

use Core\SeedWork\Domain\Events\EventDomainInterface;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\User\Domain\Entities\User;

class UserCreatedEvent implements EventDomainInterface
{
    public function __construct(private User $user)
    {
    }

    public function getEventName(): string
    {
        return 'user.created';
    }

    public function getPayload(): array
    {
        return [
            'id' => $this->user->id(),
            'name' => $this->user->name,
            'lastName' => $this->user->lastName,
            'age' => $this->user->age,
            'type' => $this->user->type instanceof CpfVO ? 'cpf' : 'cnpj',
            'document' => (string) $this->user->type,
            'address' => [
                'street' => $this->user->address->street,
                'number' => $this->user->address->number,
                'city' => $this->user->address->city,
                'state' => $this->user->address->state,
                'country' => $this->user->address->country,
                'zipCode' => $this->user->address->zipCode,
            ],
        ];
    }
}

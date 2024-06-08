<?php

namespace Core\User\Application\UseCase;

use Core\User\Application\DTO\CreateUserDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Application\Interfaces\UserCreatedEventInterface;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Events\UserCreatedEvent;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserCreatedEventInterface $eventUser,
    ) {
    }

    public function execute(CreateUserDTO $dto): OutputUserDTO
    {
        $user = new User(
            name: $dto->name,
            lastName: $dto->lastName,
            age: $dto->age,
            address: $dto->address,
            type: $dto->type
        );
        try {
            $entity = $this->repository->insert($user);
            $this->eventUser->dispatch(new UserCreatedEvent($entity));
        } catch (\Throwable $th) {
            // rollback insert (transaction)
            throw $th;
        }

        return OutputUserDTO::fromEntity($entity);
    }
}

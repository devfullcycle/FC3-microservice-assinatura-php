<?php

namespace Core\User\Application\UseCase;

use Core\SeedWork\Domain\ValueObjects\Address;
use Core\User\Application\DTO\CreateUserDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class CreateUserUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
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
        $entity = $this->repository->insert($user);

        return OutputUserDTO::fromEntity($entity);
    }
}

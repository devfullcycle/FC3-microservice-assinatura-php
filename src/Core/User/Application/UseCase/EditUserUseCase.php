<?php

namespace Core\User\Application\UseCase;

use Core\User\Application\DTO\EditUserDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class EditUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    public function execute(EditUserDTO $input): OutputUserDTO
    {
        $user = $this->repository->findById($input->id);
        $user->update(
            name: $input->name,
            lastName: $input->lastName,
            age: $input->age ?? $user->age,
        );
        $entityUpdated = $this->repository->update($user);

        return OutputUserDTO::fromEntity($entityUpdated);
    }
}

<?php

namespace Core\User\Application\UseCase;

use Core\User\Application\DTO\InputUserDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class GetUserUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(InputUserDTO $input): OutputUserDTO
    {
        $user = $this->repository->findById($input->id);

        return OutputUserDTO::fromEntity($user);
    }
}

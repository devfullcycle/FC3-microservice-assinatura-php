<?php

namespace Core\User\Application\UseCase;

use Core\User\Application\DTO\DeleteOutputUserDTO;
use Core\User\Application\DTO\InputUserDTO;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class DeleteUserUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(InputUserDTO $input): DeleteOutputUserDTO
    {
        $entity = $this->repository->findById($input->id);
        $response = $this->repository->delete($entity->id());

        return new DeleteOutputUserDTO(
            deleted: $response
        );
    }
}

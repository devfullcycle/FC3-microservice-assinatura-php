<?php

namespace Core\User\Application\UseCase;

use Core\User\Application\DTO\InputFindAllUsersDTO;
use Core\User\Application\DTO\OutputFindAllUsersDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\User\Domain\Repositories\UserRepositoryInterface;

class FindAllUsersUseCase
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(InputFindAllUsersDTO $input): OutputFindAllUsersDTO
    {
        $entities = $this->repository->findAll($input->filter, $input->orderBy);

        return new OutputFindAllUsersDTO(
            items: array_map(fn ($entity) => OutputUserDTO::fromEntity($entity), $entities),
            total: count($entities)
        );
    }
}

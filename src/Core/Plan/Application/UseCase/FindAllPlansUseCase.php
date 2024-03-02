<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\InputFindAllPlansDTO;
use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Application\DTO\OutputFindAllPlansDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class FindAllPlansUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(InputFindAllPlansDTO $input): OutputFindAllPlansDTO
    {
        $entities = $this->repository->findAll($input->filter, $input->orderBy);

        return new OutputFindAllPlansDTO(
            items: array_map(fn ($entity) => OutputPlanDTO::fromEntity($entity), $entities),
            total: count($entities)
        );
    }
}

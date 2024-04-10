<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\CreatePlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class CreatePlanUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(CreatePlanDTO $dto): OutputPlanDTO
    {
        $plan = new Plan($dto->name, $dto->description);
        $entity = $this->repository->insert($plan);

        return OutputPlanDTO::fromEntity($entity);
    }
}

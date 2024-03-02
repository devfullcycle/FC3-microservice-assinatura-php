<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Domain\Entities\Plan;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class CreatePlanUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(): OutputPlanDTO
    {
        $plan = new Plan('name', 'description');
        $entity = $this->repository->insert($plan);

        return OutputPlanDTO::fromEntity($entity);
    }
}

<?php

namespace Core\PlanCost\Application\UseCase;

use Core\PlanCost\Application\DTO\CreatePlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

class CreatePlanCostUseCase
{
    public function __construct(private PlanCostRepositoryInterface $repository)
    {
    }

    public function execute(CreatePlanCostDTO $dto): OutputPlanCostDTO
    {
        $planCost = new PlanCost(
            price: $dto->price,
            recurrencePeriod: $dto->recurrencePeriod
        );
        $entity = $this->repository->insert($planCost);

        return OutputPlanCostDTO::fromEntity($entity);
    }
}

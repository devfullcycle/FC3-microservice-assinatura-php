<?php

namespace Core\PlanCost\Application\UseCase;

use Core\PlanCost\Application\DTO\InputPlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

class GetPlanCostUseCase
{
    public function __construct(private PlanCostRepositoryInterface $repository)
    {
    }

    public function execute(InputPlanCostDTO $input): OutputPlanCostDTO
    {
        $planCost = $this->repository->findById($input->id);

        return OutputPlanCostDTO::fromEntity($planCost);
    }
}

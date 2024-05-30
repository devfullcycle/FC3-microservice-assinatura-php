<?php

namespace Core\PlanCost\Application\UseCase;

use Core\PlanCost\Application\DTO\EditPlanCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

class EditPlanCostUseCase
{
    public function __construct(
        private PlanCostRepositoryInterface $repository
    ) {
    }

    public function execute(EditPlanCostDTO $input): OutputPlanCostDTO
    {
        $planCost = $this->repository->findById($input->id);
        $planCost->update($input->price);
        $entityUpdated = $this->repository->update($planCost);

        return OutputPlanCostDTO::fromEntity($entityUpdated);
    }
}

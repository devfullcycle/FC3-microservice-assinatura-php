<?php

namespace Core\PlanCost\Application\UseCase;

use Core\PlanCost\Application\DTO\DeleteOutputPlanCostDTO;
use Core\PlanCost\Application\DTO\InputPlanCostDTO;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

class DeletePlanCostUseCase
{
    public function __construct(private PlanCostRepositoryInterface $repository)
    {
    }

    public function execute(InputPlanCostDTO $input): DeleteOutputPlanCostDTO
    {
        $entity = $this->repository->findById($input->id);
        $response = $this->repository->delete($entity->id());

        return new DeleteOutputPlanCostDTO(
            deleted: $response
        );
    }
}

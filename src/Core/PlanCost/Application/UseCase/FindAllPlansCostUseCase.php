<?php

namespace Core\PlanCost\Application\UseCase;

use Core\PlanCost\Application\DTO\InputFindAllPlansCostDTO;
use Core\PlanCost\Application\DTO\OutputFindAllPlansCostDTO;
use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\PlanCost\Domain\Repositories\PlanCostRepositoryInterface;

class FindAllPlansCostUseCase
{
    public function __construct(private PlanCostRepositoryInterface $repository)
    {
    }

    public function execute(InputFindAllPlansCostDTO $input): OutputFindAllPlansCostDTO
    {
        $entities = $this->repository->findAll($input->filter, $input->orderBy);

        return new OutputFindAllPlansCostDTO(
            items: array_map(fn ($entity) => OutputPlanCostDTO::fromEntity($entity), $entities),
            total: count($entities)
        );
    }
}

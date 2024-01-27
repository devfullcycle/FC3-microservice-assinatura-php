<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class GetPlanUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(InputPlanDTO $input): OutputPlanDTO
    {
        $plan = $this->repository->findById($input->id);

        return new OutputPlanDTO(
            id: $plan->id(),
            name: $plan->name,
            description: $plan->description,
        );
    }
}

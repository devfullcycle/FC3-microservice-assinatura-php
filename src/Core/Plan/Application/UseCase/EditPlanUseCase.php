<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\EditPlanDTO;
use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class EditPlanUseCase
{
    public function __construct(
        private PlanRepositoryInterface $repository
    ) {
    }

    public function execute(EditPlanDTO $input): OutputPlanDTO
    {
        $plan = $this->repository->findById($input->id);
        $plan->update(
            name: $input->name,
            description: $input->description
        );
        $entityUpdated = $this->repository->update($plan);

        return OutputPlanDTO::fromEntity($entityUpdated);
    }
}

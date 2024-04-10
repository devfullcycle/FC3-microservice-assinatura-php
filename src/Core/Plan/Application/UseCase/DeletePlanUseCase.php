<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Application\DTO\DeleteOutputPlanDTO;
use Core\Plan\Application\DTO\InputPlanDTO;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class DeletePlanUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(InputPlanDTO $input): DeleteOutputPlanDTO
    {
        $entity = $this->repository->findById($input->id);
        $response = $this->repository->delete($entity->id());

        return new DeleteOutputPlanDTO(
            deleted: $response
        );
    }
}

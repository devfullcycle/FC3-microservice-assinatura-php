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
        return new OutputPlanDTO();
    }
}

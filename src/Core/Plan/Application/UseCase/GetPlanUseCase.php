<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class GetPlanUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
        
    }
}

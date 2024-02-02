<?php

namespace Core\Plan\Application\UseCase;

use Core\Plan\Domain\Repositories\PlanRepositoryInterface;

class GetPlansUseCase
{
    public function __construct(private PlanRepositoryInterface $repository)
    {
    }

    public function execute(): void
    {
        
    }
}

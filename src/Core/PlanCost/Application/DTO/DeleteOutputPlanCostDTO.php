<?php

namespace Core\PlanCost\Application\DTO;

class DeleteOutputPlanCostDTO
{
    public function __construct(
        public readonly bool $deleted,
    ) {
    }
}

<?php

namespace Core\PlanCost\Application\DTO;

readonly class InputPlanCostDTO
{
    public function __construct(
        public string $id,
    ) {
    }
}

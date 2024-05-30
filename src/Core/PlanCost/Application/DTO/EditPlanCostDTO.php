<?php

namespace Core\PlanCost\Application\DTO;

readonly class EditPlanCostDTO
{
    public function __construct(
        public string $id,
        public float $price,
    ) {
    }
}

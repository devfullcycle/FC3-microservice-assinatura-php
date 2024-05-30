<?php

namespace Core\PlanCost\Application\DTO;

use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;

readonly class CreatePlanCostDTO
{
    public function __construct(
        public float $price,
        public RecurrencePeriodEnum $recurrencePeriod,
    ) {
    }
}

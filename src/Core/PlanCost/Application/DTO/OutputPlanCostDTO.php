<?php

namespace Core\PlanCost\Application\DTO;

use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;

readonly class OutputPlanCostDTO
{
    public function __construct(
        public string $id,
        public float $price,
        public string $recurrence_period,
    ) {
    }

    public static function fromEntity(PlanCost $planCost): self
    {
        return new self(
            id: $planCost->id(),
            price: $planCost->price,
            recurrence_period: $planCost->recurrencePeriod->value,
        );
    }
}

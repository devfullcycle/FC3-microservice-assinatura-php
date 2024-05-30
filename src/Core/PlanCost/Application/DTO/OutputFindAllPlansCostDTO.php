<?php

namespace Core\PlanCost\Application\DTO;

class OutputFindAllPlansCostDTO
{
    public function __construct(
        /**
         * @return array<OutPlanCostDTO>
         */
        public array $items,
        public int $total,
    ) {
    }
}

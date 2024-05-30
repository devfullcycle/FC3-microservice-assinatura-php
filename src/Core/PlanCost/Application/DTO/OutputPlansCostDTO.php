<?php

namespace Core\PlanCost\Application\DTO;

class OutputPlansCostDTO
{
    public function __construct(
        /**
         * @return array<OutPlanCostDTO>
         */
        public array $items,
        public int $total,
        public int $last_page,
        public int $total_per_page,
        public ?int $first_page,
        public ?int $next_page,
        public ?int $previous_page,
    ) {
    }
}

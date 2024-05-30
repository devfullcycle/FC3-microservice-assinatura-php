<?php

namespace Core\PlanCost\Application\DTO;

readonly class InputFindAllPlansCostDTO
{
    public function __construct(
        public string $filter = '',
        public string $orderBy = 'DESC',
    ) {
    }
}

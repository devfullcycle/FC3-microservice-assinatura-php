<?php

namespace Core\Plan\Application\DTO;

use Core\Plan\Domain\Entities\Plan;

class OutputFindAllPlansDTO
{
    public function __construct(
        /**
         * @return array<OutPlanDTO>
         */
        public array $items,
        public int $total,
    ) {
    }
}

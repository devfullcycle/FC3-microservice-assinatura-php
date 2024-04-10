<?php

namespace Core\Plan\Application\DTO;

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

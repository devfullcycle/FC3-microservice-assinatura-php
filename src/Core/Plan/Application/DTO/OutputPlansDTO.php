<?php

namespace Core\Plan\Application\DTO;

class OutputPlansDTO
{
    public function __construct(
        /**
         * @return array<OutPlanDTO>
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

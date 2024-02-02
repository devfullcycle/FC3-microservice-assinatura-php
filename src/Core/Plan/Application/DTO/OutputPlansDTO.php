<?php

namespace Core\Plan\Application\DTO;

use Core\Plan\Domain\Entities\Plan;

class OutputPlansDTO
{
    public function __construct(
        /**
         * @return array<OutPlanDTO>
         */
        public array $items,
        public int $total,
        public int $lastPage,
        public int $firstPage,
        public int $totalPerPage,
        public int $nextPage,
        public int $previousPage,
    ) {
    }
}

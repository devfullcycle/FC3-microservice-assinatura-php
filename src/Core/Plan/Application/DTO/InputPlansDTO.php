<?php

namespace Core\Plan\Application\DTO;

class InputPlansDTO
{
    public function __construct(
        public string $filter = '',
        public string $orderBy = '',
        public int $page = 1,
        public int $totalPerPage = 15
    ) {
    }
}

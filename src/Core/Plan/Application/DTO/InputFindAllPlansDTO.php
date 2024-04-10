<?php

namespace Core\Plan\Application\DTO;

class InputFindAllPlansDTO
{
    public function __construct(
        public string $filter = '',
        public string $orderBy = 'DESC',
    ) {
    }
}

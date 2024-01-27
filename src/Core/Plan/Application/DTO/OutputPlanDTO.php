<?php

namespace Core\Plan\Application\DTO;

class OutputPlanDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
    ) {
    }
}

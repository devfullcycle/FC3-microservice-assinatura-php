<?php

namespace Core\Plan\Application\DTO;

class CreatePlanDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description
    ) {
    }
}

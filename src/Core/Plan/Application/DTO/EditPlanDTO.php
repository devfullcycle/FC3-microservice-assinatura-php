<?php

namespace Core\Plan\Application\DTO;

class EditPlanDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description = null
    ) {
    }
}

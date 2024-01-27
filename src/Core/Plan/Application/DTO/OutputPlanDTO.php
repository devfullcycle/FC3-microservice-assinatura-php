<?php

namespace Core\Plan\Application\DTO;

use Core\Plan\Domain\Entities\Plan;

class OutputPlanDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
    ) {
    }

    public static function fromEntity(Plan $plan): self
    {
        return new self(
            id: $plan->id(),
            name: $plan->name,
            description: $plan->description,
        );
    }
}

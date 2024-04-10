<?php

namespace Core\Plan\Application\DTO;

class DeleteOutputPlanDTO
{
    public function __construct(
        public readonly bool $deleted,
    ) {
    }
}

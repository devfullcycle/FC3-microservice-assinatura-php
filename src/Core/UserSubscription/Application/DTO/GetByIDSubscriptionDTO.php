<?php

namespace Core\Plan\Application\DTO;

readonly class GetByIDSubscriptionDTO
{
    public function __construct(
        public string $id,
    ) {
    }
}

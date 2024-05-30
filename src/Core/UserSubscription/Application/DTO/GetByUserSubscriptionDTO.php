<?php

namespace Core\Plan\Application\DTO;

readonly class GetByUserSubscriptionDTO
{
    public function __construct(
        public string $userId,
    ) {
    }
}

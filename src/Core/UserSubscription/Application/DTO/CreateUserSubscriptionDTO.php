<?php

namespace Core\UserSubscription\Application\DTO;

readonly class CreateUserSubscriptionDTO
{
    public function __construct(
        public string $userId,
        public string $planId,
        public string $endsAt,
        public string $lastBilling,
        public bool $active = true,
        public bool $cancelled = false,
    ) {
    }
}

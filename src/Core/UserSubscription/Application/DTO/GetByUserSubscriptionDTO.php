<?php

namespace Core\UserSubscription\Application\DTO;

readonly class GetByUserSubscriptionDTO
{
    public function __construct(
        public string $userId,
    ) {
    }
}

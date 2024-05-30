<?php

namespace Core\UserSubscription\Application\DTO;

readonly class GetByIDSubscriptionDTO
{
    public function __construct(
        public string $id,
    ) {
    }
}

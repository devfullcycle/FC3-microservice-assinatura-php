<?php

namespace Core\SubscriptionTransaction\Application\DTO;

readonly class CreateSubscriptionTransactionDTO
{
    public function __construct(
        public string $userId,
        public string $planCostId,
        public string $datePayment,
        public float $amount,
    ) {
    }
}

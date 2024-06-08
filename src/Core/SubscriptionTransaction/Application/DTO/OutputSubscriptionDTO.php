<?php

namespace Core\SubscriptionTransaction\Application\DTO;

use Core\PlanCost\Application\DTO\OutputPlanCostDTO;
use Core\SubscriptionTransaction\Domain\Entities\SubscriptionTransaction;
use Core\User\Application\DTO\OutputUserDTO;

readonly class OutputSubscriptionDTO
{
    public function __construct(
        public string $id,
        public OutputUserDTO $user,
        public OutputPlanCostDTO $planCost,
        public string $date_payment,
        public float $amount,
    ) {
    }

    public static function fromEntity(SubscriptionTransaction $subscriptionTransaction): self
    {
        return new self(
            id: $subscriptionTransaction->id(),
            user: OutputUserDTO::fromEntity($subscriptionTransaction->user),
            planCost: OutputPlanCostDTO::fromEntity($subscriptionTransaction->plan),
            date_payment: $subscriptionTransaction->datePayment->format('Y-m-d H:i:s'),
            amount: $subscriptionTransaction->amount,
        );
    }
}

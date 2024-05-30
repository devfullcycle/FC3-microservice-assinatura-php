<?php

namespace Core\UserSubscription\Application\DTO;

use Core\Plan\Application\DTO\OutputPlanDTO;
use Core\User\Application\DTO\OutputUserDTO;
use Core\UserSubscription\Domain\Entities\UserSubscription;

readonly class OutputUserSubscription
{
    public function __construct(
        public OutputUserDTO $user,
        public OutputPlanDTO $plan,
        public string $ends_at,
        public string $last_billing,
        public bool $active = true,
        public bool $cancelled = false,
    ) {
    }

    public static function fromEntity(UserSubscription $userSubscription): self
    {
        return new self(
            user: OutputUserDTO::fromEntity($userSubscription->user),
            plan: OutputPlanDTO::fromEntity($userSubscription->plan),
            ends_at: $userSubscription->endsAt->format('Y-m-d H:i:s'),
            last_billing: $userSubscription->lastBilling->format('Y-m-d H:i:s'),
            active: $userSubscription->active,
            cancelled: $userSubscription->cancelled,
        );
    }
}

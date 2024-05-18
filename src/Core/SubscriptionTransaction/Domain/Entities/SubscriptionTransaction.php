<?php

namespace Core\SubscriptionTransaction\Domain\Entities;

use Core\PlanCost\Domain\Entities\PlanCost;
use Core\SeedWork\Domain\Traits\MethodsMagicTrait;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\User\Domain\Entities\User;
use DateTime;

class SubscriptionTransaction
{
    use MethodsMagicTrait;

    public function __construct(
        protected User $user,
        protected PlanCost $plan,
        protected DateTime $datePayment,
        protected float $amount,
        protected ?Uuid $id = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->validate();
    }

    public function updateDatePayment(DateTime $datePayment): void
    {
        $this->datePayment = $datePayment;
        $this->validate();
    }

    public function updateAmount(float $amount): void
    {
        $this->amount = $amount;
        $this->validate();
    }

    private function validate(): void
    {
        //
    }
}

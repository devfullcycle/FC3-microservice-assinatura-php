<?php

namespace Core\UserSubscription\Domain\Entities;

use Core\Plan\Domain\Entities\Plan;
use Core\SeedWork\Domain\Traits\MethodsMagicTrait;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\User\Domain\Entities\User;
use DateTime;

class UserSubscription
{
    use MethodsMagicTrait;

    public function __construct(
        protected User $user,
        protected Plan $plan,
        protected DateTime $endsAt,
        protected DateTime $lastBilling,
        protected bool $active,
        protected bool $cancelled,
        protected ?Uuid $id = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->validate();
    }

    public function updatePlan(Plan $plan): void
    {
        $this->plan = $plan;
        $this->validate();
    }

    public function updateLastBilling(DateTime $lastBilling): void
    {
        $this->lastBilling = $lastBilling;
        $this->validate();
    }

    public function active(): void
    {
        $this->active = true;
        $this->validate();
    }

    public function inactive(): void
    {
        $this->active = false;
        $this->validate();
    }

    public function cancel(): void
    {
        $this->cancelled = true;
        $this->validate();
    }

    public function reactive(): void
    {
        $this->cancelled = false;
        $this->validate();
    }

    public function updateEndsAt(DateTime $endsAt): void
    {
        $this->endsAt = $endsAt;
        $this->validate();
    }

    private function validate(): void
    {
        //
    }
}

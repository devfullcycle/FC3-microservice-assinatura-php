<?php

namespace Core\PlanCost\Domain\Entities;

use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\SeedWork\Domain\Traits\MethodsMagicTrait;
use Core\SeedWork\Domain\ValueObjects\Uuid;

class PlanCost
{
    use MethodsMagicTrait;

    public function __construct(
        protected float $price,
        protected RecurrencePeriodEnum $recurrencePeriod,
        protected ?Uuid $id = null,
    ) {
        $this->id = $this->id ?? Uuid::random();
        $this->validate();
    }

    public function update(float $price): void
    {
        $this->price = $price;
        $this->validate();
    }

    private function validate(): void
    {
        //
    }
}

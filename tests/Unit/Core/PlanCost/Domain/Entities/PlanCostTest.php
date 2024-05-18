<?php

use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\SeedWork\Domain\Exceptions\EntityValidationException;
use Core\SeedWork\Domain\ValueObjects\Uuid;

it('should access all properties', function () {
    $planCost = new PlanCost(
        price: 1.00,
        recurrencePeriod: RecurrencePeriodEnum::MONTHLY,
    );
    expect($planCost->price)->toBe(1.00);
    expect($planCost->recurrencePeriod)->toBe(RecurrencePeriodEnum::MONTHLY);

    expect($planCost->id)->not->toBeNull();
    expect($planCost->id())->toBeString();
});

it('should use uuid passed', function () {
    $id = Uuid::random();
    $planCost = new PlanCost(
        id: $id,
        price: 1.00,
        recurrencePeriod: RecurrencePeriodEnum::MONTHLY,
    );
    expect($planCost->id)->toBe($id);
    expect($planCost->id())->toBe((string) $id);
});

it('should throws exceptions when price is wrong', function () {
    new PlanCost(
        price: 1232131231232132131213213.0000000000000000123321,
        recurrencePeriod: RecurrencePeriodEnum::MONTHLY,
    );
})->throws(EntityValidationException::class);

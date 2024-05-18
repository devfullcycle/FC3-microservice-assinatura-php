<?php

use Core\PlanCost\Domain\Entities\PlanCost;
use Core\PlanCost\Domain\Enums\RecurrencePeriodEnum;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\SubscriptionTransaction\Domain\Entities\SubscriptionTransaction;
use Core\User\Domain\Entities\User;

beforeEach(function () {
    $cpfVo = new CpfVO('937.941.550-84');
    $address = new Address(
        street: 'street',
        city: 'city',
        state: 'state',
        country: 'country',
        zipCode: '75700-000',
        number: 1212,
    );
    $this->user = new User(name: 'John', lastName: 'Doe', age: 31, address: $address, type: $cpfVo);
    $this->planCost = new PlanCost(price: 12.12, recurrencePeriod: RecurrencePeriodEnum::ANNUALLY);
    $this->transaction = new SubscriptionTransaction(
        user: $this->user,
        plan: $this->planCost,
        datePayment: new DateTime('2000-01-20'),
        amount: 12.12,
    );
});

test('should valid type properties', function () {
    expect($this->transaction->user)->toBeInstanceOf(User::class);
    expect($this->transaction->plan)->toBeInstanceOf(PlanCost::class);
    expect($this->transaction->datePayment)->toBeInstanceOf(DateTime::class);
    expect($this->transaction->amount)->toBeFloat();
});

test('should use uuid passed', function () {
    $id = Uuid::random();
    $transaction = new SubscriptionTransaction(
        id: $id,
        user: $this->user,
        plan: $this->planCost,
        datePayment: new DateTime('12-12-2000'),
        amount: 12.12,
    );
    expect($transaction->id)->toBe($id);
    expect($transaction->id())->toBe((string) $id);
});

test('should update date payment', function () {
    expect($this->transaction->datePayment->format('Y-m-d'))->toBe('2000-01-20');

    $this->transaction->updateDatePayment(new DateTime('2026-01-25'));
    expect($this->transaction->datePayment->format('Y-m-d'))->toBe('2026-01-25');
});

test('should update amount', function () {
    $this->transaction->updateAmount(14.14);
    expect($this->transaction->amount)->toBe(14.14);
});

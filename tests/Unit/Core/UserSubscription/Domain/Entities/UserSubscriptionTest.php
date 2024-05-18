<?php

use Core\Plan\Domain\Entities\Plan;
use Core\SeedWork\Domain\ValueObjects\Address;
use Core\SeedWork\Domain\ValueObjects\CpfVO;
use Core\SeedWork\Domain\ValueObjects\Uuid;
use Core\User\Domain\Entities\User;
use Core\UserSubscription\Domain\Entities\UserSubscription;

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
    $this->plan = new Plan(name: 'Basic', description: 'Basic plan');
    $this->subscription = new UserSubscription(
        user: $this->user,
        plan: $this->plan,
        endsAt: new DateTime('12-12-2000'),
        lastBilling: new DateTime('12-12-2000'),
        active: true,
        cancelled: false,
    );
});

test('should valid type properties', function () {
    expect($this->subscription->user)->toBeInstanceOf(User::class);
    expect($this->subscription->plan)->toBeInstanceOf(Plan::class);
    expect($this->subscription->endsAt)->toBeInstanceOf(DateTime::class);
    expect($this->subscription->lastBilling)->toBeInstanceOf(Datetime::class);
    expect($this->subscription->active)->toBeBool();
    expect($this->subscription->cancelled)->toBeBool();
});

test('should use uuid passed', function () {
    $id = Uuid::random();
    $subscription = new UserSubscription(
        id: $id,
        user: $this->user,
        plan: $this->plan,
        endsAt: new DateTime('12-12-2000'),
        lastBilling: new DateTime('12-12-2000'),
        active: true,
        cancelled: false,
    );
    expect($subscription->id)->toBe($id);
    expect($subscription->id())->toBe((string) $id);
});

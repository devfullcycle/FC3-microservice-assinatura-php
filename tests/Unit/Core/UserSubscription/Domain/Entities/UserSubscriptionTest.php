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

test('should update plan', function () {
    expect($this->subscription->plan->name)->toBe($this->plan->name);

    $newPlan = new Plan(name: 'Premium', description: 'Premium plan');
    $this->subscription->updatePlan($newPlan);
    expect($this->subscription->plan->name)->toBe($newPlan->name);
});

test('should update update Last Billing', function () {
    expect($this->subscription->lastBilling->format('Y-m-d'))->toBe('2000-12-12');

    $this->subscription->updateLastBilling(new DateTime('2026-01-25'));
    expect($this->subscription->lastBilling->format('Y-m-d'))->toBe('2026-01-25');
});

test('should update update ends at', function () {
    expect($this->subscription->endsAt->format('Y-m-d'))->toBe('2000-12-12');

    $this->subscription->updateEndsAt(new DateTime('2026-01-25'));
    expect($this->subscription->endsAt->format('Y-m-d'))->toBe('2026-01-25');
});

test('should update active and inactive', function () {
    expect($this->subscription->active)->toBe(true);
    $this->subscription->inactive();
    expect($this->subscription->active)->toBe(false);
    $this->subscription->active();
    expect($this->subscription->active)->toBe(true);
});

test('should cancel and disable cancel', function () {
    expect($this->subscription->cancelled)->toBe(false);
    $this->subscription->cancel();
    expect($this->subscription->cancelled)->toBe(true);
    $this->subscription->reactive();
    expect($this->subscription->cancelled)->toBe(false);
});
